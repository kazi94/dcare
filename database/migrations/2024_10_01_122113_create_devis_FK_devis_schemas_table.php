<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->foreign('patient_id', 'FK_devis_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('schema_id', 'FK_devis_schemas')->references('id')->on('schemas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'FK_devis_users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('updated_by', 'FK_devis_users_2')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropForeign('FK_devis_schemas');
        });
    }
};
