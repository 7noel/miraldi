<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picking_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('picking_id'); // Relación con la tabla picking
            $table->string('CFNUMPED');
            $table->string('codigo'); // Relación con la tabla productos
            $table->string('codigo2');
            $table->string('name'); // Descipcion de los productos
            $table->decimal('quantity', 15, 2); // Cantidad despachada
            $table->decimal('quantity_ordered', 15, 2); // Cantidad pedida
            $table->decimal('quantity_invoiced', 15, 2); // Cantidad facturada
            $table->decimal('quantity_pending_billing', 15, 2); // Cantidad pendiente de facturación
            $table->string('invoice'); // Serie y Numero de Factura
            $table->dateTime('is_invoiced')->nullable();; // Fecha de la factura
            $table->bigInteger('user_id'); // Relación con el usuario
            $table->timestamps();
            
            // Índices para optimizar consultas futuras
            $table->index(['codigo', 'is_invoiced']); // Índice para buscar por producto y estado de facturación
            $table->index('quantity_pending_billing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('picking_details');
    }
}
