<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->date('issued_at');
            $table->string('number');
            $table->boolean('is_output');
            $table->decimal('value', 12, 2);
            $table->decimal('exchange', 7, 4);
            $table->integer('bank_id')->unsigned();
            $table->integer('currency_id')->unsigned();

            $table->string('tipo_operacion');
            $table->string('cta_origen');
            $table->string('cta_destino');
            $table->string('titular_destino');
            $table->integer('currency2_id')->unsigned();
            $table->decimal('monto', 12, 2);

            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('payments');
    }
}
