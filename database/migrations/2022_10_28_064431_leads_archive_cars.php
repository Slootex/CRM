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
        Schema::create('leads_archive_cars', function (Blueprint $table) {
            $table->string("process_id")->nullable();;
            $table->string("car_company")->nullable();;
            $table->string("car_model")->nullable();;
            $table->string("production_year")->nullable();;
            $table->string("car_identification_number")->nullable();
            $table->string("car_power")->nullable();
            $table->string("mileage")->nullable();
            $table->string("transmission")->nullable();;
            $table->string("fuel_type")->nullable();;
            $table->string("broken_component")->nullable();;
            $table->string("from_car")->nullable();;
            $table->string("device_manufacturer")->nullable();
            $table->string("device_partnumber")->nullable();
            $table->string("error_message_cache")->nullable();
            $table->string("error_message")->nullable();
            $table->string("component_company")->nullable();
            $table->string("component_number")->nullable();
            $table->rememberToken();
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
        //
    }
};
