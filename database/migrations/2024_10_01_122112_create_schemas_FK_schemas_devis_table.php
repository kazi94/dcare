<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createschemas_FK_schemas_devisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schemas', function (Blueprint $table) {
            $table->foreign('devis_id', 'FK_schemas_devis')->references('id')->on('devis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schemas', function(Blueprint $table){
            $table->dropForeign('FK_schemas_devis');
        });
    }
}
