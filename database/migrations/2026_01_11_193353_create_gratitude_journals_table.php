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
        Schema::create('gratitude_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('positive_thing_1');
            $table->text('positive_thing_2');
            $table->text('positive_thing_3');
            $table->date('journal_date');
            $table->timestamps();

            $table->index('user_id');
            $table->index('journal_date');
            $table->index(['user_id', 'journal_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gratitude_journals');
    }
};
