<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateprescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('medicaments');
            $table->date('date_prescription')->nullable();
            $table->unsignedInteger('patient_id');
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            
            $table->foreign('patient_id', 'FK__patients')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by', 'FK_prescriptions_users')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('updated_by', 'FK_prescriptions_users_2')->references('id')->on('users')->onDelete('set NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
