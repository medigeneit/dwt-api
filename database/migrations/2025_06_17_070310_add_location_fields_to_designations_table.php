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
                $table->unsignedInteger('permanent_district_id')->nullable()->after('college_id');
                $table->unsignedInteger('permanent_upazila_id')->nullable()->after('permanent_district_id');
                $table->unsignedInteger('current_upazila_id')->nullable()->after('permanent_upazila_id');
                $table->unsignedInteger('current_district_id')->nullable()->after('current_upazila_id');

                $table->foreign('permanent_district_id')->references('id')->on('districts')->onDelete('set null');
                $table->foreign('permanent_upazila_id')->references('id')->on('upazilas')->onDelete('set null');
                $table->foreign('current_upazila_id')->references('id')->on('upazilas')->onDelete('set null');
                $table->foreign('current_district_id')->references('id')->on('districts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designations', function (Blueprint $table) {
           $table->dropForeign(['permanent_district_id']);
            $table->dropForeign(['permanent_upazila_id']);
            $table->dropForeign(['current_upazila_id']);
            $table->dropForeign(['current_district_id']);

            // Then drop columns
            $table->dropColumn([
                'permanent_district_id',
                'permanent_upazila_id',
                'current_upazila_id',
                'current_district_id'
            ]);
        });
    }
};
