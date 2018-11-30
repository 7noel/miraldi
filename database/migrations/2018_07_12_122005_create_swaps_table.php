<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swaps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('my_company')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('is_output')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->boolean('is_cancel');
            $table->decimal('amount_proofs', 12, 2);
            $table->decimal('amount_letters', 12, 2);

            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swaps');
    }
}
