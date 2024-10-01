<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createacte_formuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acte_formule', function (Blueprint $table) {
            $table->unsignedInteger('acte_id');
            $table->integer('formule_id');
            $table->string('color', 15)->nullable();
            
            $table->foreign('acte_id', 'FK_formule_acte_actes')->references('id')->on('actes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('formule_id', 'FK_formule_acte_formules')->references('id')->on('formules')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acte_formule');
    }
}
