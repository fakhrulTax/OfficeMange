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
            $table->string('email');
            $table->integer('mobile')->unique();
            $table->string('bangla_name');
            $table->string('type');
<<<<<<< HEAD
            $table->tinyInteger('fiel_in_stock')->default(0);
=======
            $table->tinyInteger('file_in_stock');
>>>>>>> 5b48246cb76b165fc64c4e010dfc0a652d05f3b9
            $table->string('file_rack');
            $table->integer('circle');
            $table->string('address')->nullable();;
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
