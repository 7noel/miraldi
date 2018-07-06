<?php namespace App\Modules\Storage;


use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['warehouse_id', 'product_id', 'stock', 'stock_initial', 'stock_min', 'stock_max', 'currency_id', 'avarage_value'];

	public function warehouse()
	{
		return $this->belongsTo('App\Modules\Storage\WareHouse');
	}
	public function product()
	{
		return $this->belongsTo('App\Modules\Storage\Product');
	}
	public function purchase_details()
	{
		return $this->hasMany('App\Modules\Logistics\PurchaseDetail');
	}
}
