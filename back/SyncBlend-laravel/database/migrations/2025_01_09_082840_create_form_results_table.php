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
        Schema::create('form_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('total_agresivitat_counter')->nullable();
            $table->integer('agresivitat_fisica_counter')->nullable();
            $table->integer('agresivitat_verbal_counter')->nullable();
            $table->integer('agresivitat_relacional_counter')->nullable();
            $table->boolean('total_agresivitat')->default(false);
            $table->boolean('agresivitat_fisica')->default(false);
            $table->boolean('agresivitat_verbal')->default(false);
            $table->boolean('agresivitat_relacional')->default(false);

            $table->integer('prosocialitat_counter')->nullable();
            $table->boolean('prosocialitat')->default(false);

            $table->integer('total_victimizacio_counter')->nullable();
            $table->integer('victimizacio_fisica_counter')->nullable();
            $table->integer('victimizacio_verbal_counter')->nullable();
            $table->integer('victimizacio_relacional_counter')->nullable();
            $table->boolean('total_victimizacion')->default(false);
            $table->boolean('victimizacion_fisica')->default(false);
            $table->boolean('victimizacion_verbal')->default(false);
            $table->boolean('victimizacion_relacional')->default(false);

            $table->boolean('popular')->default(false);
            $table->boolean('rebutjat')->default(false);
            $table->boolean('ignorat')->default(false);
            $table->boolean('controvertit')->default(false);
            $table->boolean('normatiu')->default(false);

            $table->integer('tries_positives')->nullable();
            $table->integer('tries_negatives')->nullable();

            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_result');
    }
};
