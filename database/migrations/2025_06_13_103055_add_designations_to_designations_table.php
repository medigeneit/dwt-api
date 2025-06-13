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
        Schema::table('designations', function (Blueprint $table) {
            $table->string('class_grade')->nullable()->after('college_id');
            $table->string('alternate_phone')->nullable()->after('class_grade');
            $table->string('skill_expertise')->nullable()->after('alternate_phone');
            $table->text('description')->nullable()->after('skill_expertise');
            $table->text('previous_experience')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->dropColumn([
                'class_grade',
                'alternate_phone',
                'skill_expertise',
                'description',
                'previous_experience',
            ]);
        });
    }
};
