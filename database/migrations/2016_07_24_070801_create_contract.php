<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContract
 */
class CreateContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            // CUPS can't be unique cause could be more than one contract with that cups (but in different dates)
            $table->string('cups');
            // Type = tariff contracted
            $table->smallInteger('type');

            $table->boolean('comission_paid');

            // Annual mean consuption
            $table->string('mean_consuption');

            $table->integer('client_id')->unsigned();
            /* $table->foreign('client_id')
                ->references('id')->on('client'); */
            $table->integer('supplier_company_id')->unsigned();
            /* $table->foreign('supplier_company_id')
                ->references('id')->on('supplier_company'); */

            // Supply address -> for each contract
            $table->integer('supply_address_id')->unsigned()->nullable();
            /* $table->foreign('supply_address_id')
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
        Schema::drop('contract');
    }
}
