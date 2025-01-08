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
        Schema::create('question_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_question'); // Usuario que responde
            $table->unsignedBigInteger('id_form'); // Grupo del formulario;
            $table->timestamps();

            $table->foreign('id_question')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('id_form')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_forms');
    }
};
