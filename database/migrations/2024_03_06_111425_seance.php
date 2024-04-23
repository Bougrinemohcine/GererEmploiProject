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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->enum('day',['lundi', 'mardi','mercredi','jeudi','vendredi','samedi']);
            $table->enum('partie_jour', ['Matin', 'A.Midi']);
            $table->enum('order_seance', ['s1', 's2','s3','s4']);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedBigInteger('id_salle');
            $table->unsignedBigInteger('id_formateur');
            $table->unsignedBigInteger('id_groupe');
            $table->unsignedBigInteger('id_emploi');
            $table->foreign('id_salle')->references('id')->on('salles')->onUpdate('cascade');
            $table->foreign('id_formateur')->references('id')->on('formateurs')->onUpdate('cascade');
            $table->foreign('id_groupe')->references('id')->on('groupes')->onUpdate('cascade');
            $table->foreign('id_emploi')->references('id')->on('emplois')->onUpdate('cascade')->onDelete('cascade');;
            $table->enum('type_seance',['presentielle','team','efm']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
