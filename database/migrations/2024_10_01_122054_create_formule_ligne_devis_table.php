<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createformule_ligne_devisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formule_ligne_devis', function (Blueprint $table) {
            $table->unsignedInteger('ligne_devis_id')->nullable();
            $table->integer('formule_id')->nullable();
            $table->string('color', 15)->nullable();
            
            $table->foreign('formule_id', 'FK__formules')->references('id')->on('formules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ligne_devis_id', 'FK__lignedevis')->references('id')->on('lignedevis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formule_ligne_devis');
    }
}
