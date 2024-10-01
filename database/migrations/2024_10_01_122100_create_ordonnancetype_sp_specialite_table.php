<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createordonnancetype_sp_specialiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordonnancetype_sp_specialite', function (Blueprint $table) {
            $table->unsignedInteger('ordonnancetype_id');
            $table->integer('sp_specialite_id');
            
            $table->primary(['ordonnancetype_id', 'sp_specialite_id']);
            $table->foreign('ordonnancetype_id', 'FK_ordonnancetype_sp_specialite_ordonnancetypes')->references('id')->on('ordonnancetypes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sp_specialite_id', 'FK_ordonnancetype_sp_specialite_sp_specialite')->references('SP_CODE_SQ_PK')->on('sp_specialite')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordonnancetype_sp_specialite');
    }
}
