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
        Schema::create('leads_archive_persons', function (Blueprint $table) {
            $table->string("process_id");
            $table->string("employee");
            $table->string("company_name")->nullable();
            $table->string("gender");
            $table->string("firstname");
            $table->string("lastname");
            $table->string("email");
            $table->string("phone_number")->nullable();
            $table->string("mobile_number")->nullable();
            $table->string("home_street");
            $table->integer("home_street_number");
            $table->string("home_zipcode");
            $table->string("home_city")->nullable();;
            $table->string("home_country")->nullable();;
            $table->string("send_back_company_name")->nullable();
            $table->string("send_back_gender")->nullable();
            $table->string("send_back_firstname")->nullable();
            $table->string("send_back_lastname")->nullable();
            $table->string("send_back_street")->nullable();
            $table->string("send_back_street_number")->nullable();
            $table->string("send_back_zipcode")->nullable();
            $table->string("send_back_city")->nullable();
            $table->string("send_back_country")->nullable();
            
            $table->string("pricemwst");
            $table->string("shipping_type");
            $table->string("payment_type");
            $table->string("submit_type");

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
