<?php

namespace App\Http\Controllers;

use App\Dto\Projects\ProjectRenderJobDto;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\RenderRequest;
use App\Jobs\ProjectRenderJob;
use App\Models\Media;
use App\Models\Project;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request): JsonResponse
    {
        $project = Project::query()->create([
            'name' => $request->input('name'),
            'width' => $request->input('width', 0),
            'height' => $request->input('height', 0)
        ]);

        return response()->json($project);
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
}
