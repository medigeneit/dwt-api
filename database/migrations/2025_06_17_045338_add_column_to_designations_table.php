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
            $table->unsignedBigInteger('did_registration_id')->after('user_id');
            $table->foreign('did_registration_id')
                ->references('id')
                ->on('did_registrations')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->dropForeign(['did_registration_id']);
            $table->dropColumn('did_registration_id');
        });
    }
};
