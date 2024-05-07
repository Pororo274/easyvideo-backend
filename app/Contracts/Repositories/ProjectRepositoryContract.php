<?php

namespace App\Contracts\Repositories;

use App\Dto\Projects\CreateProjectDto;
use App\Models\Project;

interface ProjectRepositoryContract
{
    public function store(CreateProjectDto $dto): Project;
}
