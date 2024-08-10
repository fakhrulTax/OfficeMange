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
        Schema::create('retarns', function (Blueprint $table) {
            $table->id();
            $table->string('register');
            $table->date('return_submission_date');
            $table->bigInteger('register_serial');
            $table->bigInteger('tin');
            $table->integer('assessment_year'); 
            $table->string('source_of_income')->nullable();
            $table->bigInteger('income')->default(0);
            $table->bigInteger('income_of_poultry_fisheries')->default(0);
            $table->bigInteger('income_of_remittance')->default(0);       

            $table->bigInteger('tax_of_schedule_one')->nullable()->default(0);
            $table->bigInteger('special_tax')->nullable()->default(0);
            $table->bigInteger('special_invest')->nullable()->default(0);   

            $table->bigInteger('source_tax')->nullable()->default(0);
            $table->bigInteger('advance_tax')->nullable()->default(0);
            $table->bigInteger('retarn_tax')->nullable()->default(0);
            $table->bigInteger('late_fee')->nullable()->default(0);
            $table->bigInteger('sercharge')->nullable()->default(0);
            $table->bigInteger('total_tax')->nullable()->default(0);

            $table->bigInteger('liabilities')->nullable()->default(0);
            $table->bigInteger('net_asset')->nullable()->default(0);            
            $table->string('comments')->nullable();
            
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
        Schema::dropIfExists('retarns');
    }
};
