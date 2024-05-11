<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ProjectServiceContract;
use App\Dto\Projects\CreateProjectDto;
use App\Dto\Projects\ProjectRenderJobDto;
use App\Enums\Projects\ProjectConfigEnum;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\RenderRequest;
use App\Jobs\ProjectRenderJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    //TODO: pick nodes from db
    public function render(RenderRequest $request)
    {
        ProjectRenderJob::dispatch(new ProjectRenderJobDto(
            projectId: $request->input('project_id'),
            nodes: $request->input('nodes')
        ));

        return response()->json([
            'status' => 'Render started'
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
}
