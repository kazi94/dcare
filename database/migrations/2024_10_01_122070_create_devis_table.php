<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state', 20);
            $table->unsignedSmallInteger('discount')->nullable();
            $table->unsignedMediumInteger('total')->nullable();
            $table->unsignedMediumInteger('total_accept')->nullable();
            $table->unsignedInteger('schema_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->tinyInteger('accepted')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis');
    }
}
