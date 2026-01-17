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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Relation polymorphique
            $table->morphs('mediable'); // mediable_id + mediable_type

            // Infos media
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->enum('media_type', ['image', 'audio', 'video']);
            $table->string('file_path');
            $table->integer('duration')->nullable();
            $table->timestamps();

            $table->index('media_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
