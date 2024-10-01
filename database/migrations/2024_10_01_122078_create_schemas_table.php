<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateschemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schemas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->nullable();
            $table->timestamps();
            $table->string('type', 50)->nullable();
            $table->unsignedInteger('devis_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schemas');
    }
}
