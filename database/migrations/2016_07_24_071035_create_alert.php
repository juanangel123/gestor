<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAlert
 */
class CreateAlert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert', function(Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type');

            // Contract
            $table->integer('contract_id')->unsigned()->nullable();

            // If the alert is created but not sended, checking here
            $table->smallInteger('sended');

            // Ts
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
        Schema::drop('alert');
    }
}
