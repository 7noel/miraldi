<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('intern_code');
			$table->string('provider_code');
			$table->string('manufacturer_code');
			$table->string('name');
			$table->text('description');
			$table->integer('country_id')->unsigned();
			$table->integer('brand_id')->unsigned();
			$table->string('model');
			$table->integer('sub_category_id')->unsigned();
			$table->integer('unit_id')->unsigned();
			$table->integer('currency_id')->unsigned();

			$table->decimal('last_purchase', 15, 2);
			$table->decimal('profit_margin', 10, 2);
			$table->decimal('value', 15, 2);
			$table->boolean('use_set_value');
			$table->boolean('is_downloadable');
			$table->integer('status')->unsigned()->default(1);

			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->foreign('sub_category_id')->references('id')->on('sub_categories');
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
		Schema::dropIfExists('products');
	}

}
