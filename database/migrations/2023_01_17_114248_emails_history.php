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
        Schema::create('emails_history', function (Blueprint $table) {
            $table->string("process_id")->nullable();
            $table->string("employee")->nullable();
            $table->string("status")->nullable();
            $table->string("subject")->nullable();
            $table->string("email")->nullable();
            $table->string("body")->nullable();

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
