<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('appointements', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->timestamps();
            // $table->string('text')->nullable();
            // $table->date('date_rdv');
            // $table->dateTime('start_date', 0);
            // $table->dateTime('end_date', 0);
            
            // $table->foreignId('patient_id')
            // ->constrained('patients')
            // ->onDelete('cascade');
            // $table->foreignId('created_by')
            // ->constrained('users')
            // ->onDelete('cascade');
            //     });
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
