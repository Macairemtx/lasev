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
        Schema::create('events', function (Blueprint $table) {
           $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->dateTime('event_date');
            $table->string('location')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('current_participants')->default(0);

            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])
                  ->default('upcoming');

            $table->timestamps();

            $table->index('event_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
