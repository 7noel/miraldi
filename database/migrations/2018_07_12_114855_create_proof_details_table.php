<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProofDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proof_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proof_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->decimal('value', 15, 2);
            $table->decimal('price', 15, 2);
            $table->decimal('quantity', 15, 2);
            $table->decimal('discount', 15, 2);
            $table->decimal('d1',15,2);
            $table->decimal('d2',15,2);
            $table->decimal('cost', 15, 2);
            $table->decimal('total',15,2);
            $table->integer('igv_code')->unsigned();
            $table->text('comment');

            $table->foreign('proof_id')->references('id')->on('proofs');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('unit_id')->references('id')->on('units');
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
        Schema::dropIfExists('proof_details');
    }
}
