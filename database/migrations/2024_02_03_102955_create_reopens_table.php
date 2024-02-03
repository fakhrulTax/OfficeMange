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
            $table->json('reopen_date');
            $table->json('main_income');
            $table->json('main_tax');
            $table->json('expire_date');
            $table->json('disposal_date')->nullable();
            $table->json('assessed_income')->nullable();
            $table->json('demand')->nullable();
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
