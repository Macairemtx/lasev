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
        Schema::create('retreat_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            
            // Détails du plan
            $table->integer('duration_days');
            
            // Images
            $table->string('cover_image')->nullable();
            
            // Features (JSON)
            $table->json('features')->nullable();
            
            // Tags (JSON)
            $table->json('tags')->nullable();
            
            // Services (JSON)
            $table->json('services')->nullable();
            
           
            // Statut et pricing
            $table->enum('status', ['available', 'on_request', 'coming_soon'])->default('available');
            $table->decimal('price', 10, 2)->nullable();
          
            $table->timestamps();
            
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retreat_plans');
    }
};
