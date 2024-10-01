<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateversementslogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versementslogs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedInteger('versement_id')->nullable();
            
            $table->foreign('updated_by', 'FK_versements_log_users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('versement_id', 'FK_versements_log_versements')->references('id')->on('versements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versementslogs');
    }
}
