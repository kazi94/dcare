<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateversementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('devis_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedMediumInteger('total_paid');
            $table->unsignedInteger('paid_by')->nullable();
            $table->date('paid_at');
            
            $table->foreign('devis_id', 'FK__devis')->references('id')->on('devis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paid_by', 'FK__users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('patient_id', 'FK_versements_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versements');
    }
}
