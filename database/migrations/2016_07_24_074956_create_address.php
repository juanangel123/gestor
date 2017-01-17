<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAddress
 */
class CreateAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function(Blueprint $table) {
            $table->increments('id');
            $table->string('line');
            $table->string('postcode');

            $table->integer('province_id')->unsigned()->nullable();
            $table->string('locality');
            /* $table->foreign('province_id')
                ->references('id')->on('province'); */
            /*$table->integer('municipality_id')->unsigned()->nullable(); */
            /* $table->foreign('municipality_id')
                ->references('id')->on('municipality')
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
        Schema::drop('address');
    }
}
