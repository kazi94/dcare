<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateligneprescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligneprescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prescription_id');
            $table->integer('medicament_id');
            $table->string('medicament', 50)->nullable();
            $table->date('date_prise')->nullable();
            $table->string('status', 30)->nullable();
            
            $table->foreign('prescription_id', 'FK_ligneprescriptions_prescriptions')->references('id')->on('prescriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('medicament_id', 'FK_ligneprescriptions_sp_specialite')->references('SP_CODE_SQ_PK')->on('sp_specialite')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligneprescriptions');
    }
}
