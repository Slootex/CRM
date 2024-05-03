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
        Schema::create('entsorgung_extendtime', function (Blueprint $table) {
            $table->id();
            $table->string("process_id")->nullable();
            $table->string("component_id")->nullable();
            $table->string("component_number")->nullable();
            $table->string("component_type")->nullable();
            $table->string("component_count")->nullable();
            $table->string("days")->nullable();


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
