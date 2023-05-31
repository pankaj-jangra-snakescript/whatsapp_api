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
    public $timestamps = false;

    public function up()
    {

        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_id');
            $table->string('phone_no_id');
            $table->string('name');
            $table->string('wa_id');
            $table->string('receipient_id');
            $table->string('status');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('threads');
    }
};
