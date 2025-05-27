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
        Schema::create('did_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('session');
            $table->string('batch');
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->timestamps();

            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('did_registrations');
    }
};
