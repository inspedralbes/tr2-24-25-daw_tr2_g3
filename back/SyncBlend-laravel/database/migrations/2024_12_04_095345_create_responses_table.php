<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); // Usuario que responde
            $table->unsignedBigInteger('id_question'); // Pregunta respondida
            $table->unsignedBigInteger('id_answer'); // Usuario seleccionado como respuesta
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_question')->references('id')->on('questions');
            $table->foreign('id_answer')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
}

