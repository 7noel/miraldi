<?php namespace App\Modules\Storage;


use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['name', 'intern_code', 'provider_code', 'manufacturer_code', 'description', 'category_id', 'sub_category_id', 'unit_id', 'currency_id', 'country', 'brand', 'last_purchase', 'profit_margin', 'admin_expense', 'value_cost', 'price_cost', 'value', 'price', 'use_set_value', 'is_downloadable', 'is_visible', 'my_company'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%")->orWhere('intern_code', 'LIKE', "%$name%");
		}
	}
	public function category()
	{
		return $this->belongsTo('App\Modules\Base\Table','category_id');
	}
	public function sub_category()
	{
		return $this->belongsTo('App\Modules\Base\Table','sub_category_id');
	}
	public function unit()
	{
		return $this->belongsTo('App\Modules\Base\Table','unit_id');
	}
	// public function marca()
	// {
	// 	return $this->belongsTo('App\Modules\Base\Table','brand');
	// }
	public function stocks()
	{
		return $this->hasMany('App\Modules\Storage\Stock');
	}
	public function accessories()
	{
		return $this->hasMany('App\Modules\Storage\ProductAccessory','product_id','id');
	}
	public function product()
	{
		return $this->hasMany('App\Modules\Storage\ProductAccessory','accessory_id','id');
	}
	public function tables()
	{
		return $this->morphMany('App\Modules\Base\Table', 'table');
	}
}
