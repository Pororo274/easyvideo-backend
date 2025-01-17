<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('virtual_media', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('content_type');
            $table->string('content');
            $table->integer('layer');
            $table->foreignId('project_id')->constrained()->onDelete('CASCADE');
            $table->jsonb('filters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_media');
    }
};
