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
        Schema::create('donor_members', function (Blueprint $table) {
            $table->id();
            $table->string('member_type');
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->boolean('is_foreign')->default(false);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->text('address')->nullable();

            $table->string('donor_type');
            $table->string('donation_purpose');
            $table->string('donation_scope');
            $table->decimal('amount', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_members');
    }
};
