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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Personal Info
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('nid_or_birth_cert')->nullable();
            $table->string('image')->nullable();

            // Academic Info
            $table->foreignId('college_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_year')->nullable(); // like 2013-2014
            $table->string('batch')->nullable();
            $table->string('roll_number')->nullable();
            $table->string('bmdc_reg_number')->nullable();

            // DID Number
            $table->string('did_number')->unique()->nullable();

            // Contact Info
            $table->string('mobile')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
