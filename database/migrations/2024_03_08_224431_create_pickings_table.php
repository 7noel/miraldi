<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickings', function (Blueprint $table) {
            $table->id();
            $table->string('CFNUMPED');
            $table->json('details')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('items', 12, 2);
            $table->decimal('pl', 12, 2);
            $table->decimal('es', 12, 2);
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
        Schema::dropIfExists('pickings');
    }
}
