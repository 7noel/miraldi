<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmortizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amortizations', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('value_proof', 12, 2);
            $table->decimal('value_payment', 12, 2);
            $table->integer('proof_id')->unsigned();
            $table->integer('payment_id')->unsigned();

            $table->foreign('proof_id')->references('id')->on('proofs');
            $table->foreign('payment_id')->references('id')->on('payments');
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
        Schema::dropIfExists('amortizations');
    }
}
