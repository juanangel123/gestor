<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePowerContracted
 */
class CreatePowerContracted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('power_contracted', function(Blueprint $table) {
            $table->increments('id');

            // Total power contracted
            $table->string('total');

            $table->integer('contract_id')->unsigned();
            /* $table->foreign('contract_id')
                ->references('id')->on('contract'); */

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
        Schema::drop('power_contracted');
    }
}
