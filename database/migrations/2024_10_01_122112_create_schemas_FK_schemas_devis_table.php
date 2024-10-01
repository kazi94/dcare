<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchemasFKSchemasDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schemas', function (Blueprint $table) {
            $table->foreign('patient_id', 'FK_schemas_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('created_by', 'FK_schemas_users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
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
        Schema::table('schemas', function (Blueprint $table) {
            $table->dropForeign('FK_schemas_devis');
        });
    }
}
