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
            
            $table->foreign('devis_id', 'FK_schemas_devis')->references('id')->on('devis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id', 'FK_schemas_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'FK_schemas_users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
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
