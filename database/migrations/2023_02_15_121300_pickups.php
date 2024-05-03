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
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->string("employee")->nullable();
            $table->string("shortcut")->nullable();
            $table->string("refrence")->nullable();
            $table->string("pickup_date")->nullable();
            $table->string("status")->nullable();
            $table->string("packages")->nullable();
            $table->string("weight")->nullable();
            $table->string("notice")->nullable();
            $table->string("companyname")->nullable();
            $table->string("gender")->nullable();
            $table->string("firstname")->nullable();
            $table->string("lastname")->nullable();
            $table->string("street")->nullable();
            $table->string("streetnumber")->nullable();
            $table->string("zipcode")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->string("email")->nullable();
            $table->string("phonenumber")->nullable();
            $table->string("mobilnumber")->nullable();

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
