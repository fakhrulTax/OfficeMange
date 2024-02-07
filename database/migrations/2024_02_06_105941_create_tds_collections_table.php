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
        Schema::create('tds_collections', function (Blueprint $table) {
            $table->id();
            $table->text('collection_month');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('organization_id');
            $table->bigInteger('bill');
            $table->bigInteger('tds')->nullable();
            $table->integer('circle');
            $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

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
        Schema::dropIfExists('tds_collections');
    }
};
