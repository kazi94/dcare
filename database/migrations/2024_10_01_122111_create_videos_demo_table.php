<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosDemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_demo', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('url')->nullable();
            $table->unsignedInteger('act_id')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();

            $table->foreign('act_id', 'FK__actess')->references('id')->on('actes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'FK__userss')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos_demo');
    }
}
