<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createantecedent_patientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedent_patient', function (Blueprint $table) {
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('antecedent_id')->index('FK_antecedent_patient_antecedents');
            
            $table->foreign('patient_id', 'FK_antecedent_patient_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antecedent_patient');
    }
}
