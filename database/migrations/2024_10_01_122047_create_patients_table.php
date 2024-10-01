<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 50)->default('0');
            $table->string('prenom', 50)->default('0');
            $table->date('date_naissance')->nullable();
            $table->string('profession', 50)->nullable();
            $table->string('adresse')->nullable();
            $table->string('sexe', 2)->nullable();
            $table->string('fumeur', 3)->nullable();
            $table->string('medecin_externe', 50)->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->text('num_tel')->nullable();
            $table->text('motif')->nullable();
            $table->string('motivation', 50)->nullable();
            
            $table->foreign('created_by', 'FK_patients_users')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('updated_by', 'FK_patients_users_2')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
