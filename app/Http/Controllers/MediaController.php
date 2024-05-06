<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreChunkRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function storeChunk(StoreChunkRequest $request)
    {
        $chunk = $request->file('chunk');

        if (is_null($request->input('media_id'))) {
            $path = "media/" . $chunk->hashName();

            $media = Media::query()->create([
                'path' => $path,
                'project_id' => $request->input('project_id')
            ]);
        } else {
            $media = Media::query()->find($request->input('media_id'));
            $path = $media->path;
        }

        $absolutePath = Storage::disk('local')->path($path);
        File::append($absolutePath, $chunk->get());

        return response()->json($media);
    }
}
