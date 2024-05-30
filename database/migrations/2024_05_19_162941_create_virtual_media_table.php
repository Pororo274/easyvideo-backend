<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected function setDimensionsFields(Blueprint $table): void
    {
        $table->decimal('width');
        $table->decimal('height');
        $table->decimal('crop_width');
        $table->decimal('crop_height');
        $table->decimal('x_position');
        $table->decimal('y_position');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('virtual_media', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('type');
            $table->decimal('global_start_time');
            $table->decimal('duration');
            $table->integer('layer');
            $table->foreignId('project_id');
            $table->decimal('start_time');
            $table->timestamps();
        });

        Schema::create('virtual_videos', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->decimal('original_duration');

            $this->setDimensionsFields($table);

            $table->uuid('media_uuid');
            $table->timestamps();
        });

        Schema::create('virtual_images', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $this->setDimensionsFields($table);

            $table->uuid('media_uuid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_videos');
        Schema::dropIfExists('virtual_images');
        Schema::dropIfExists('virtual_media');
    }
};
