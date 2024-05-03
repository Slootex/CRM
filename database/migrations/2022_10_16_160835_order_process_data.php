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
        Schema::create('oder_process_data', function (Blueprint $table) {
            $table->string("process_id");
            $table->string("component_id")->nullable();
            $table->string("component_type")->nullable();
            $table->string("component")->nullable();
            $table->string("device_manufacturer")->nullable();
            $table->string("device_partnumber")->nullable();
            $table->string("from_car")->nullable();
            $table->string("open_by_user")->nullable();
            $table->string("other_components")->nullable();
            $table->string("info")->nullable();
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
