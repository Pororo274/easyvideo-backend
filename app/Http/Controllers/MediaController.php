<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MediaServiceContract;
use App\Dto\Media\SaveChunkDto;
use App\Http\Requests\Media\StoreChunkRequest;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function storeChunk(StoreChunkRequest $request, MediaServiceContract $mediaService)
    {
        $media = $mediaService->saveChunk(new SaveChunkDto(
            chunk: $request->file('chunk'),
            projectId: $request->input('project_id'),
            last: $request->input('last'),
            mediaUuid: $request->input('media_uuid'),
            originalName: $request->input('original_name')
        ));

        return response()->json($media);
    }
}
