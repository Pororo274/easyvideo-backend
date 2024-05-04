<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

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

    public function render(Request $request)
    {

        //TODO: pick nodes from db
        $nodes = $request->input('nodes');

        $assets = ['assets/input.mp4'];
        $assetsNames = collect([
            ['clientId' => '1234', 'streamName' => '0']
        ]);
        $outputExtenstion = '.mp4';


        $ffmpeg = FFMpeg::fromDisk('local')
            ->export()
            ->open($assets)
            ->toDisk('local')
            ->inFormat(new X264('aac'));

        foreach ($nodes as $node) {
            $nodeFilterType = $node['type'];

            switch ($nodeFilterType) {
                case 'trim':
                    $streamName = $assetsNames->where('clientId', $node['clientId'])->first()['streamName'];
                    $command = ['[' . $streamName . ']', 'trim=' . $node['startWith'] . ':' . $node['end'] . ',setpts=PTS-STARTPTS', '[srat]'];
                    $ffmpeg->addFilter($command);
                    break;
            }
        }

        $ffmpeg->save('outputs/' . 'zalupa' . $outputExtenstion);

        return response()->json([
            'message' => 'Render started'
        ]);
    }
}
