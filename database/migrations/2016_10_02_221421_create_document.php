<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContractDocument
 */
class CreateDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document', function(Blueprint $table) {
            $table->increments('id');

            // Document can be part of clients OR contracts
            $table->integer('contract_id')->unsigned();
            /* $table->foreign('contract_id')
                ->references('id')->on('contract'); */

            $table->integer('client_id')->unsigned();
            /* $table->foreign('client_id')
                ->references('id')->on('client'); */

            $table->string('name');
            // Relative path
            $table->string('path');

            $table->string('mime_type');
            $table->string('size');

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
        Schema::drop('contract_document');
    }
}
