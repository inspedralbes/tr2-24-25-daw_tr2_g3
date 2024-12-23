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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('phone')->after('email')->nullable();
            $table->string('nationality')->after('phone')->nullable();
            $table->string('gender')->after('nationality')->nullable();
            $table->integer('postal_code')->after('gender')->nullable();
            $table->string('city')->after('postal_code')->nullable();
            $table->string('province')->after('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
