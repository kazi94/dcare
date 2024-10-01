<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state', 20);
            $table->unsignedSmallInteger('discount')->nullable();
            $table->unsignedMediumInteger('total')->nullable();
            $table->unsignedMediumInteger('total_accept')->nullable();
            $table->unsignedInteger('schema_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->tinyInteger('accepted')->nullable();
            
            $table->foreign('patient_id', 'FK_devis_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('schema_id', 'FK_devis_schemas')->references('id')->on('schemas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'FK_devis_users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('updated_by', 'FK_devis_users_2')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis');
    }
}