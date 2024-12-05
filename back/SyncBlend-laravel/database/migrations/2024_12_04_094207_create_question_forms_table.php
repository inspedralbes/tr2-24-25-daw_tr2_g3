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
            $table->unsignedBigInteger('idQuestion'); // Usuario que responde
            $table->unsignedBigInteger('idForm'); // Grupo del formulario;
            $table->timestamps();

            $table->foreign('idQuestion')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('idForm')->references('id')->on('forms')->onDelete('cascade');
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
