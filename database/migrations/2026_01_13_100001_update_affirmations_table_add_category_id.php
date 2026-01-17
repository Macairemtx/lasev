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
        Schema::table('affirmations', function (Blueprint $table) {
            // Supprimer l'ancienne clé étrangère si elle existe (vers categories)
            if (Schema::hasColumn('affirmations', 'category_id')) {
                // Vérifier si la contrainte existe
                $foreignKeys = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableForeignKeys('affirmations');
                
                foreach ($foreignKeys as $foreignKey) {
                    if (in_array('category_id', $foreignKey->getColumns())) {
                        $table->dropForeign([$foreignKey->getName()]);
                    }
                }
                
                $table->dropColumn('category_id');
            }
            
            // Ajouter la nouvelle colonne avec la bonne clé étrangère
            $table->foreignId('category_id')->nullable()->after('id')->constrained('affirmation_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affirmations', function (Blueprint $table) {
            if (Schema::hasColumn('affirmations', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};

