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
        Schema::create('arrears', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tin');
            $table->string('arrear_type');
            $table->date('demand_create_date');
            $table->integer('assessment_year');
            $table->BigInteger('arrear');
            $table->BigInteger('fine')->nullable();
            $table->integer('circle');    
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('arrears');
    }
};
