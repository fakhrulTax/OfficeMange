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
            $table->bigInteger('tin')->unique();
            $table->string('name');
            $table->string('sort_name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('bangla_name');
            $table->string('type')->nullable();;
            $table->tinyInteger('file_in_stock')->nullable();;
            $table->string('file_rack')->nullable();;
            $table->integer('circle');
            $table->text('address')->nullable();;
            $table->integer('last_return')->nullable();;
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
