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
        Schema::create('contact_persons', function (Blueprint $table) {
            $table->id();        
            $table->unsignedBigInteger('zilla_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('organization_id');
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('mobile_number'); 
            $table->string('email')->nullable();
            $table->integer('circle');
            $table->foreign('zilla_id')->references('id')->on('zillas')->onDelete('cascade');
            $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');        
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
        Schema::dropIfExists('contact_persons');
    }
};
