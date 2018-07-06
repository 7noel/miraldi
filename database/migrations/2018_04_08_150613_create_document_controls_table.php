<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentControlsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('document_controls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('document_type_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->integer('series')->unsigned();
			$table->integer('number')->unsigned();

            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('company_id')->references('id')->on('companies');
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
		Schema::dropIfExists('document_controls');
	}

}
