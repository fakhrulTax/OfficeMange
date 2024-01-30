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
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->bigInteger('tin');
            $table->string('appeal_order');
            $table->date('appeal_order_date');
            $table->date('appeal_disposal_date');
            $table->integer('assessment_year');
            $table->integer('main_income');
            $table->integer('main_tax');
            $table->integer('revise_income');
            $table->integer('revise_tax');
            $table->integer('circle');
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
        Schema::dropIfExists('appeals');
    }
};
