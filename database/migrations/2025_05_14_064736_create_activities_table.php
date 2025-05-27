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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();              // Activity title (e.g., Free Medical Camp)
            $table->text('description')->nullable();        // Details about the activity
            $table->string('location')->nullable();         // Place of the activity
            $table->date('activity_date')->nullable();      // When it happened
            $table->string('photo')->nullable();            // Optional image (store S3/public path)
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
