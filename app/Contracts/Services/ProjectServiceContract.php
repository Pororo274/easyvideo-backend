<?php

namespace App\Contracts\Services;

use App\Dto\Projects\CreateProjectDto;
use App\Models\Project;

interface ProjectServiceContract
{
    public function store(CreateProjectDto $dto): Project;
}
