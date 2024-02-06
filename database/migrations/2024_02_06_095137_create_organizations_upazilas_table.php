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
        Schema::create('organizations_upazilas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('upazilas_id');
            $table->unsignedBigInteger('organizations_id');

            $table->foreign('upazilas_id')->references('id')->on('upazilas')->onDelete('cascade');
            $table->foreign('organizations_id')->references('id')->on('organizations')->onDelete('cascade');

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
        Schema::dropIfExists('organizations_upazilas');
    }
};
