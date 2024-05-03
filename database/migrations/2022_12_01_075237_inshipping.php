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
        Schema::create('inshipping', function (Blueprint $table) {
            $table->string("process_id")->nullable();
            $table->string("component_number")->nullable();
            $table->string("label_id")->nullable();
            $table->string("type")->nullable();
            $table->string("firstname")->nullable();
            $table->string("lastname")->nullable();
            $table->string("shortcut")->nullable();
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
