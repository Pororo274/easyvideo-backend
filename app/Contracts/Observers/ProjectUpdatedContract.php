<?php

namespace App\Contracts\Observers;

use Illuminate\Support\Carbon;

interface ProjectUpdatedContract
{
    public function getProjectId(): int;
}
