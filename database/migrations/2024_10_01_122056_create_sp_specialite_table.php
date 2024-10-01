<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createsp_specialiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_specialite', function (Blueprint $table) {
            $table->integer('SP_CODE_SQ_PK')->primary();
            $table->integer('SP_GSP_CODE_FK')->nullable()->index('FK1_SP_SPECIALITE');
            $table->string('SP_CATC_CODE_FK', 10)->nullable()->index('FK3_SP_SPECIALITE');
            $table->string('SP_CEPH_CODE_FK', 10)->nullable()->index('FK4_SP_SPECIALITE');
            $table->integer('SP_CGE_CODE_FK')->nullable()->index('FK5_SP_SPECIALITE');
            $table->integer('SP_ALGERIE')->nullable();
            $table->string('SP_NOM', 100);
            $table->string('SP_DOSE', 100)->nullable();
            $table->string('SP_COPIE', 10)->nullable();
            
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_specialite');
    }
}
