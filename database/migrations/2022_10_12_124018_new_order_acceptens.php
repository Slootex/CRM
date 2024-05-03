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
        Schema::create('new_order_acceptens', function (Blueprint $table) {
            $table->string("process_id");
            $table->string("back_shipping_type");
            $table->string("payment_type");
            $table->string("agb_agree");
            $table->string("privacy_agree");
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
