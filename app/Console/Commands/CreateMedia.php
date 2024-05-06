<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;

class CreateMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:create {projectId} {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create media database instance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $media = Media::query()->create([
            'project_id' => $this->argument('projectId'),
            'path' => $this->argument('path')
        ]);

        $this->info('Media instance successfully created with id '.$media->id);
    }
}
