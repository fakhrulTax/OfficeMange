<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reopens', function (Blueprint $table) {
            $table->id();
            $table->integer('tin');
            $table->integer('assessment_year');
            $table->date('reopen_date');
            $table->bigInteger('main_income');
            $table->bigInteger('main_tax');
            $table->date('expire_date');
            $table->date('disposal_date')->nullable();
            $table->bigInteger('assessed_income')->nullable();
            $table->bigInter('demand')->nullable();
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
        Schema::dropIfExists('reopens');
    }
};
