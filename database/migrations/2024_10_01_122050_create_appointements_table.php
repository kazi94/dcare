<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateappointementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointements', function (Blueprint $table) {
            $table->id();
            $table->string('text')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('color', 10)->nullable();
            $table->string('textColor', 10)->nullable();
            $table->tinyInteger('fauteuil')->nullable();
            $table->string('state', 10)->nullable();
            $table->timestamp('state_modified_at')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('assign_to')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->string('event_id')->nullable();
            
            $table->foreign('category_id', 'FK_appointements_categories')->references('id')->on('categories')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('patient_id', 'FK_appointements_patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'FK_appointements_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('assign_to', 'FK_appointements_users_2')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by', 'FK_appointements_users_3')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointements');
    }
}
