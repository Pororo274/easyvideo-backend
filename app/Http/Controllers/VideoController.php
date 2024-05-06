<?php

namespace App\Http\Controllers;

use App\Dto\FFMpeg\TrimFilterDto;
use App\Helpers\FFMpegHelper;
use App\Models\Asset;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Filesystem\Media;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

/**
 * @deprecated
 */
class VideoController extends Controller
{
    public function uploadChunk(Request $request): JsonResponse
    {
        $asset = Asset::query()->where('client_id', $request->input('clientId'))->first();
        $chunk = $request->file('chunk');
        $filepath = $asset->path ?? "assets/" . $chunk->hashName();

        $path = Storage::disk('local')->path($filepath);
        File::append($path, $chunk->get());

        if (is_null($asset)) {
            $asset = Asset::query()->create([
                'client_id' => $request->input('clientId'),
                'path' => $filepath
            ]);
        }

        return response()->json($asset);
    }

    // public function render(Request $request): JsonResponse
    // {
    //     $media = $request->input('medias')[0];
    //     $node = $request->input('nodes')[0];

    //     $asset = Asset::query()->where('client_id', $media['clientId'])->first();
    //     $assetName = basename(Storage::disk('local')->path($asset->path));

    //     FFMpeg::fromDisk('local')
    //         ->open($asset->path)
    //         ->export()
    //         ->toDisk('local')
    //         ->inFormat(new X264('aac'))
    //         ->addFilter('-ss', TimeCode::fromSeconds($node['videoStartWith']))
    //         ->addFilter('-to', TimeCode::fromSeconds($node['currentVideoDuration']))
    //         ->save('outputs/' . $assetName);

    //     return response()->json([
    //         'status' => 'success'
    //     ]);
    // }


    //TODO: render must be a QUEUE!!!
    public function render(Request $request)
    {

        //TODO: pick nodes from db

        $media = $request->input('medias')[0];
        $asset = Asset::query()->where('client_id', $media['clientId'])->first();
        $nodes = $request->input('nodes');

        $assets = [$asset->path, $asset->path];
        $assetsNames = collect([
            ['clientId' => $media['clientId'], 'streamName' => '0']
        ]);
        $outputExtenstion = '.mp4';


        $ffmpeg = FFMpeg::fromDisk('local')
            ->open($assets)
            ->export();

        foreach ($nodes as $node) {
            $nodeFilterType = $node['type'];

            switch ($nodeFilterType) {
                case 'trim':
                    $streamName = $assetsNames->where('clientId', $node['clientId'])->first()['streamName'];
                    $ffmpeg->addFilter(function (ComplexFilters $filters) use($streamName, $node) {
                        $filters->custom('[' . $streamName . ':v]', FFMpegHelper::getTrimFilterCommand(new TrimFilterDto(start: $node['videoStartWith'], end: $node['currentVideoDuration'])), '[0v]');
                        $filters->custom('[' . $streamName . ':a]', FFMpegHelper::getATrimFilterCommand(new TrimFilterDto(start: $node['videoStartWith'], end: $node['currentVideoDuration'])), '[0a]');
                    });
                    break;
            }
        }

        $ffmpeg->addFormatOutputMapping(new X264, Media::make('local', 'outputs/zalupa.mp4'), ['[0v]', '[0a]']);

        $ffmpeg
            ->toDisk('local')
            ->inFormat(new X264('aac'));

        $ffmpeg->save();

        return response()->json([
            'message' => 'Render started'
        ]);
    }
}
