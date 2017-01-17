<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConfig
 */
class CreateConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function(Blueprint $table) {
            $table->increments('id');

            // Protection
            $table->smallInteger('protection');

            // Last time alerted
            $table->timestamp('last_time_alert');

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
        Schema::drop('config');
    }
}
