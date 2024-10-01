<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetraitementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traitements', function (Blueprint $table) {
            $table->unsignedInteger('schema_id');
            $table->integer('formule_id');
            $table->integer('teeth')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            
            $table->primary(['schema_id', 'formule_id']);
            $table->foreign('formule_id', 'traitements_ibfk_1')->references('id')->on('formules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('schema_id', 'traitements_ibfk_2')->references('id')->on('schemas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'traitements_ibfk_3')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('updated_by', 'traitements_ibfk_4')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traitements');
    }
}
