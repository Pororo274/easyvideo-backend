<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MediaServiceContract;
use App\Dto\Media\SaveChunkDto;
use App\Http\Requests\Media\StoreChunkRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    public function findAllByProjectId(int $projectId, MediaServiceContract $mediaService)
    {
        return $mediaService->findAllByProjectId($projectId);
    }

    public function getMedia(string $mediaName): BinaryFileResponse
    {
        return response()->file(Storage::path('media/' . $mediaName));
    }
}
