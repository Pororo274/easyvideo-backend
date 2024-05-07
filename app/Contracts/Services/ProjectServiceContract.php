<?php

namespace App\Contracts\Services;

use App\Dto\Projects\CreateProjectDto;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectServiceContract
{
    public function store(CreateProjectDto $dto): Project;
    public function getAllByUserId(int $userId): Collection;
}
