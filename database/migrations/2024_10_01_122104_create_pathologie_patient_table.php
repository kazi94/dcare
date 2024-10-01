<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createpathologie_patientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathologie_patient', function (Blueprint $table) {
            $table->unsignedInteger('patient_id');
            $table->string('pathologie_id', 5);
            
            $table->primary(['patient_id', 'pathologie_id']);
            $table->foreign('pathologie_id', 'fk_path_pat_cst')->references('id')->on('pathologies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id', 'FK_pathologie_patient_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pathologie_patient');
    }
}
