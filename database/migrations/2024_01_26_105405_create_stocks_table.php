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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tin');
            $table->string('name');
            $table->string('sort_name');
            $table->string('email');
            $table->integer('mobile');
            $table->string('bangla_name');
            $table->string('type');
            $table->tinyInteger('file_in_stock');
            $table->string('file_rack');
            $table->integer('circle');
            $table->string('address');
            $table->integer('last_return');
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
        Schema::dropIfExists('stocks');
    }
};
