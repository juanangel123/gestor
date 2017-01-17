<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMunicipality
 */
class CreateMunicipality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipality', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('province_id')->unsigned();
            /* $table->foreign('province_id')
                ->references('id')->on('province'); */
            // Ts
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('municipality');
    }
}
