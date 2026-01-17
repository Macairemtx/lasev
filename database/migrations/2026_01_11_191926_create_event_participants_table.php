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
        Schema::create('event_participants', function (Blueprint $table) {
           $table->id();
             $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['registered', 'cancelled', 'attended'])->default('registered');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
            
            $table->unique(['event_id']);
            $table->index('event_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
