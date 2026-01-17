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
        Schema::table('food_comfort_forms', function (Blueprint $table) {
            $table->foreignId('retreat_plan_id')->nullable()->constrained('retreat_plans')->onDelete('set null')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_comfort_forms', function (Blueprint $table) {
            $table->dropForeign(['retreat_plan_id']);
            $table->dropColumn('retreat_plan_id');
        });
    }
};
