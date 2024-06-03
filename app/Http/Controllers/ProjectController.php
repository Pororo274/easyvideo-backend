<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\ProjectServiceContract;
use App\Contracts\Services\VirtualMediaServiceContract;
use App\Dto\Projects\CreateProjectDto;
use App\Dto\Projects\ProjectRenderJobDto;
use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\VirtualVideoDto;
use App\Enums\Projects\ProjectConfigEnum;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\RenderRequest;
use App\Jobs\ProjectRenderJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request, ProjectServiceContract $projectService): JsonResponse
    {
        $projectConfigDto = ProjectConfigEnum::from($request->input('config'))->toProjectConfigDto();

        $project = $projectService->store(new CreateProjectDto(
            name: $request->input('name'),
            width: $projectConfigDto->width,
            height: $projectConfigDto->height,
            fps: $projectConfigDto->fps,
            userId: Auth::id()
        ));

        return response()->json($project);
    }

    public function getConfigs(): JsonResponse
    {
        return response()->json(ProjectConfigEnum::getConfigs());
    }

    public function render(int $projectId, ProjectServiceContract $projectService)
    {
        $project = $projectService->findById($projectId);

        ProjectRenderJob::dispatch(new ProjectRenderJobDto(
            userId: Auth::id(),
            projectId: $projectId,
            width: $project->width,
            height: $project->height,
        ));

        return response()->json([
            'status' => 'Exporting...'
        ]);
    }

    public function getAllByUserId(int $userId, ProjectServiceContract $projectService): JsonResponse
    {
        $projects = $projectService->getAllByUserId($userId);

        return response()->json($projects);
    }

    public function findById(int $projectId, ProjectServiceContract $projectService): JsonResponse
    {
        $project = $projectService->findById($projectId);

        return response()->json($project);
    }

    public function downloadOutputFile(string $filename)
    {
        return response()->download(Storage::path("temp-media/{$filename}"), $filename);
    }
}
