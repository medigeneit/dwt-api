<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('did_registrations', function (Blueprint $table) {
            $table->string('nid')->unique()->nullable()->after('id');
            $table->string('bmdc')->unique()->nullable()->after('nid');
            $table->string('roll')->nullable()->after('bmdc');
            $table->string('facebook_link')->nullable()->after('roll');
        });
    }

    public function down(): void
    {
        Schema::table('did_registrations', function (Blueprint $table) {
            $table->dropColumn(['nid', 'bmdc', 'roll', 'facebook_link']);
        });
    }
};
