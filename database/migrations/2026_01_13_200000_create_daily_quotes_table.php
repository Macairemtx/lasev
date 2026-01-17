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
        Schema::create('daily_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_1')->comment('Phrase pour 00:00 - 11:59');
            $table->string('quote_2')->comment('Phrase pour 12:00 - 22:59');
            $table->string('quote_3')->comment('Phrase pour 23:00 - 23:59');
            $table->date('quote_date')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('quote_date');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_quotes');
    }
};

