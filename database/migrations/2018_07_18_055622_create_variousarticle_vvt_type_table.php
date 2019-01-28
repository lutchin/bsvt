<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariousarticleVvtTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variousarticle_vvt_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vvt_type_id')->index();
            $table->integer('variousarticle_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variousarticle_vvt_type');
    }
}