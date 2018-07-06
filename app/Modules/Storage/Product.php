<?php namespace App\Modules\Storage;


use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['name', 'intern_code', 'provider_code', 'manufacturer_code', 'description', 'sub_category_id', 'unit_id', 'currency_id', 'country_id', 'brand_id', 'model', 'last_purchase', 'profit_margin', 'value', 'use_set_value', 'is_downloadable'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	public function sub_category()
	{
		return $this->belongsTo('App\Modules\Storage\SubCategory');
	}
	public function unit()
	{
		return $this->hasOne('App\Modules\Storage\Unit','id','unit_id');
	}
	public function stocks()
	{
		return $this->hasMany('App\Modules\Storage\Stock');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}
	public function brand()
	{
		return $this->belongsTo('App\Modules\Logistics\Brand');
	}
	public function accessories()
	{
		return $this->hasMany('App\Modules\Storage\ProductAccessory','product_id','id');
	}
	public function product()
	{
		return $this->hasMany('App\Modules\Storage\ProductAccessory','accessory_id','id');
	}
	public function attributes()
	{
		return $this->morphMany('App\Modules\Base\Attribute', 'attribute');
	}
	public function pictures()
    {
        return $this->morphMany('App\Modules\Base\Picture', 'picture');
    }
	public function purchase_details()
	{
		return $this->hasMany('App\Modules\Logistics\PurchaseDetail');
	}
	public function country()
	{
		return $this->hasOne('App\Modules\Base\SunatTable','id','country_id');
	}

}
