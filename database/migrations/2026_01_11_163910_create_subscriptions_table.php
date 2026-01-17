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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('plan_type', ['monthly', 'yearly']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('XOF');

            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');

            $table->timestamp('started_at');
            $table->timestamp('expires_at')->nullable(); // ✅ CORRECTION

            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
