<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('prenom', 50)->nullable();
            $table->string('email', 50)->unique('users_email_unique');
            $table->string('profession', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 240);
            $table->string('api_token', 80)->nullable()->unique('users_api_token_unique');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedInteger('cabinet_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->text('last_login')->nullable();
            $table->text('current_login')->nullable();
            $table->string('color', 15)->nullable();

            $table->foreign('cabinet_id', 'FK_users_cabinets')->references('id')->on('cabinets')->onDelete('set NULL')->onUpdate('cascade');
            $table->foreign('role_id', 'FK_users_roles')->references('id')->on('roles')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
