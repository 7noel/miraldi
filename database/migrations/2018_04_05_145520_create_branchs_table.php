<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('branches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('company_id')->unsigned();
			$table->string('name');
			$table->string('address');
			$table->integer('ubigeo_id')->unsigned();
			$table->integer('country_id')->unsigned()->default(1461);
			$table->string('phone');
			$table->string('mobile');
			$table->string('email');
			$table->string('contact');
			$table->string('comment');

			$table->foreign('company_id')->references('id')->on('companies');
			$table->foreign('ubigeo_id')->references('id')->on('ubigeos');
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
		Schema::dropIfExists('branchs');
	}

}
