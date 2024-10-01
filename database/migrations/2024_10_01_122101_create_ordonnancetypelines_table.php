<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateordonnancetypelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordonnancetypelines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicament', 50)->nullable();
            $table->unsignedInteger('medicament_id')->nullable();
            $table->unsignedTinyInteger('nb_prise')->nullable();
            $table->unsignedTinyInteger('frequence')->nullable();
            $table->text('preview')->nullable();
            $table->unsignedInteger('ordonnancetype_id');
            $table->string('forme', 50)->nullable();
            
            $table->foreign('ordonnancetype_id', 'FK__ordonnancetypes')->references('id')->on('ordonnancetypes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordonnancetypelines');
    }
}
