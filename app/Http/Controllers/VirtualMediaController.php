<?php

namespace App\Http\Controllers;

use App\Contracts\Services\VirtualMediaServiceContract;
use App\Dto\VirtualMedia\SyncVirtualMediaDto;
use App\Helpers\VirtualMediaHelper;
use App\Http\Requests\VirtualMedia\CreateVirtualMediaRequest;
use App\Http\Requests\VirtualMedia\VirtualMediaSyncRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VirtualMediaController extends Controller
{
    public function findAllByProjectId(int $projectId, VirtualMediaServiceContract $virtualMediaService): JsonResponse
    {
        $virtualMedias = $virtualMediaService->findAllByProjectId($projectId);

        return response()->json($virtualMedias);
    }

    public function sync(int $projectId, VirtualMediaSyncRequest $request, VirtualMediaServiceContract $virtualMediaService): JsonResponse
    {
        $virtualMedias = $request->input('virtualMedias');

        $syncedVirtualMedias = $virtualMediaService->sync(new SyncVirtualMediaDto(
            projectId: $projectId,
            virtualMedias: collect($virtualMedias)
        ));

        return response()->json($syncedVirtualMedias);
    }
}
