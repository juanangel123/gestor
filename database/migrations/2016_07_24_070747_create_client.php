<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClient
 *
 * @link http://stackoverflow.com/questions/35899188/cannot-migrate-with-foreign-key-in-laravel-5-2
 */
class CreateClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            /*$table->string('first_name');
            $table->string('last_name');*/
            $table->string('telephone');
            $table->string('mobile');
            $table->string('email')->unique();
            $table->smallInteger('client_type');
            $table->string('vat_id');

            // Address
            $table->integer('address_id')->unsigned()->nullable();
            /* $table->foreign('address_id')
                ->references('id')->on('address')
                ->onDelete('cascade'); */

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
        Schema::drop('client');
    }
}
