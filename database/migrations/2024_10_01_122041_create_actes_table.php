<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateactesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_cnas', 50)->nullable();
            $table->string('nom', 200)->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->float('price')->unsigned()->default(0);
            $table->string('type', 10)->nullable();
            $table->string('shortcut', 10)->nullable();
            
            $table->foreign('category_id', 'FK_actes_categories')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actes');
    }
}
