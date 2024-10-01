<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createpre_presentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_presentation', function (Blueprint $table) {
            $table->string('PRE_CODE_PK', 10)->primary();
            $table->integer('PRE_SP_CODE_FK');
            $table->string('PRE_EAN_REF', 13)->nullable();
            $table->smallInteger('PRE_NBUNITE')->nullable();
            $table->string('PRE_CDF_UP_CODE_FK', 10)->nullable();
            $table->string('PRE_CACDT_TEXTE', 4000)->nullable();
            $table->string('PRE_CDF_RH_CODE_FK', 10);
            $table->string('PRE_CDF_LI_CODE_FK', 10)->nullable();
            $table->string('PRE_ETAT_COMMER', 2)->nullable();
            $table->dateTime('PRE_DATECOMMER')->nullable();
            $table->dateTime('PRE_DATESUP')->nullable();
            $table->string('PRE_CDF_PU_CODE_FK', 10)->nullable();
            $table->string('PRE_CEPH_CODE_FK', 10)->nullable()->index('FK2_PRE_PRESENTATION');
            $table->string('PRE_CATC_CODE_FK', 10)->nullable()->index('FK3_PRE_PRESENTATION');
            $table->string('PRE_NATUCD_CDF_CODE_FK', 10)->nullable();
            $table->char('PRE_NATUCD_CDF_NUM_FK', 2)->nullable();
            $table->dateTime('PRE_DATEJOCIP')->nullable();
            $table->char('PRE_AGRCOLL', 1)->nullable();
            $table->dateTime('PRE_DATEJOCOLL')->nullable();
            $table->dateTime('PRE_DATEFINCOLL')->nullable();
            $table->dateTime('PRE_DATE_APPLIFINCOLL')->nullable();
            $table->string('PRE_PARTSTATUT', 4000)->nullable();
            $table->string('PRE_TSS_TEXTE', 4000)->nullable();
            $table->longText('PRE_CONSAPOUV')->nullable();
            $table->string('PRE_LIB_CEPS', 750)->nullable();
            $table->string('PRE_ADMIN', 600)->nullable();
            $table->dateTime('PRE_DATEMJ')->nullable();
            
            $table->foreign('PRE_SP_CODE_FK', 'FK_pre_presentation_sp_specialite')->references('SP_CODE_SQ_PK')->on('sp_specialite')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_presentation');
    }
}
