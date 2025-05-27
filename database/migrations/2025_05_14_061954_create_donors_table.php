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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['supreme', 'elite', 'premium', 'standard', 'basic']);
            $table->enum('donation_type', ['trust_fund', 'campaign', 'case_specific']);
            $table->decimal('amount', 10, 2);
            $table->string('ssl_transaction_id')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
