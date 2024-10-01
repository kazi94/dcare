<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatelignedevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lignedevis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('devis_id');
            $table->unsignedInteger('acte_id');
            $table->string('num_dent', 100);
            $table->string('state', 20);
            $table->boolean('accepted_state')->default(0);
            $table->unsignedSmallInteger('price')->default(0);
            $table->timestamps();
            $table->string('lock', 6)->nullable();
            
            $table->foreign('acte_id', 'FK_lignedevis_actes')->references('id')->on('actes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('devis_id', 'FK_lignedevis_devis')->references('id')->on('devis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lignedevis');
    }
}
