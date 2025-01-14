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
        /**
         * Table for see result, that have the same that excel result CESC
         * Ex: {total: [
         *          {
         *              Total_agresivitat:3,
         *              agresivitat_fisica:1
         *          }
         *      ]}
         */
        Schema::create('form_answer_totals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('user_id');
            $table->json('result')->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_answer_totals');
    }
};
