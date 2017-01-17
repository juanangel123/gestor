<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSupplierCompany
 */
class CreateSupplierCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_company', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');

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
        Schema::drop('supplier_company');
    }
}
