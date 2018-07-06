<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSunatTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sunat_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('catalog');
            $table->integer('table')->unsigned();
            $table->string('code');
            $table->string('description');
            $table->string('other1');
            $table->string('other2');
            $table->boolean('is_activated');
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
        Schema::dropIfExists('sunat_tables');
    }
}
