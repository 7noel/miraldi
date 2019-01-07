<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('company_name');
			$table->string('brand_name');
			$table->string('name');
			$table->string('paternal_surname');
			$table->string('maternal_surname');
			$table->integer('id_type_id')->unsigned();
			$table->string('doc');
			$table->string('address');
			$table->integer('ubigeo_id')->unsigned();
			$table->integer('country_id')->unsigned()->default(1461);
			$table->string('phone');
			$table->string('mobile');
			$table->string('email');
			$table->string('email_1');
			$table->string('email_2');
			$table->string('contact');
			$table->string('comment');
			$table->date('birth')->nullable();
			$table->boolean('is_client');
			$table->boolean('is_provider');
			$table->boolean('is_my_company');
			$table->boolean('is_shipper');
			$table->string('bank_bcp');
			$table->string('bank_other');
			
			$table->integer('currency_id')->unsigned()->default(1);
			$table->decimal('credit', 15, 2);

			$table->foreign('id_type_id')->references('id')->on('id_types');
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
		Schema::dropIfExists('companies');
	}

}
