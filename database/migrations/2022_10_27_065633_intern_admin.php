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
        Schema::create('intern_admin', function (Blueprint $table) {
            $table->string("process_id")->nullable();
            $table->string("prox_time")->nullable();
            $table->string("result")->nullable();
            $table->string("to_phonehistory")->nullable();
            $table->string("allowness_1")->nullable();
            $table->string("verbal_contract")->nullable();
            $table->string("talked_partner")->nullable();
            $table->string("shipping_after_payment")->nullable();
            $table->string("release")->nullable();
            $table->string("takeback_insturction")->nullable();
            $table->string("change_instruction")->nullable();
            $table->string("birthday")->nullable();
            $table->string("allowness_2")->nullable();
            $table->string("employee")->nullable();
            $table->string("company_name")->nullable();
            $table->string("gender")->nullable();
            $table->string("firstname")->nullable();
            $table->string("lastname")->nullable();
            $table->string("email")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("mobile_number")->nullable();
            $table->string("home_street")->nullable();
            $table->integer("home_street_number")->nullable();
            $table->string("home_zipcode")->nullable();
            $table->string("home_city")->nullable();
            $table->string("home_country")->nullable();
            $table->string("send_back_company_name")->nullable();
            $table->string("send_back_gender")->nullable();
            $table->string("send_back_firstname")->nullable();
            $table->string("send_back_lastname")->nullable();
            $table->string("send_back_street")->nullable();
            $table->string("send_back_street_number")->nullable();
            $table->string("send_back_zipcode")->nullable();
            $table->string("send_back_city")->nullable();
            $table->string("send_back_country")->nullable();

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
