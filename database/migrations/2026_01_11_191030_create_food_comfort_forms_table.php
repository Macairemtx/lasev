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
        Schema::create('food_comfort_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            
            // Allergies
            $table->boolean('has_allergies')->default(false);
            $table->string('allergy_food')->nullable();
            $table->text('allergy_reaction')->nullable();
            $table->json('allergy_type')->nullable(); // ['contact', 'ingestion']
            
            // Intolérances
            $table->text('intolerances')->nullable();
            
            // Régimes spécifiques (JSON)
            $table->json('specific_diets')->nullable(); // ['vegetarien', 'vegan', 'sans_porc', 'sans_gluten', 'halal']
            
            // Ingrédients de bonheur (JSON - 3 max)
            $table->json('happiness_ingredients')->nullable();
            
            // Aliments par dégoût
            $table->text('disliked_foods')->nullable();
            
            // Épices
            $table->enum('spice_level', ['tres_doux', 'medium', 'releve'])->nullable();
            
            // Inspirations culinaires (JSON)
            $table->json('culinary_inspirations')->nullable(); // ['asiatique', 'orientale', 'terroir', 'mediterraneen']
            
            // Plat réconfort
            $table->string('comfort_dish')->nullable();
            
            // Petit déjeuner
            $table->enum('breakfast_preference', ['sucre', 'sale', 'pas_de_petit_dej'])->nullable();
            
            // Boissons chaudes (JSON)
            $table->json('hot_drinks')->nullable(); // ['cafe', 'the_noir', 'infusion', 'autre']
            
            // Boissons végétales (JSON)
            $table->json('plant_drinks')->nullable(); // ['lait_soja', 'lait_avoine', 'lait_animal']
            
            // Collations
            $table->boolean('needs_snacks')->default(false);
            
            // Commentaires libres
            $table->text('free_comments')->nullable();
            
            $table->timestamps();
            
            $table->unique('user_id'); // Un user = une seule fiche
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_comfort_forms');
    }
};
