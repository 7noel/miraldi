<?php

namespace App\Modules\Operations;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['order_id', 'product_id', 'stock_id', 'unit_id', 'category_id', 'sub_category_id', 'is_downloadable', 'price', 'value', 'quantity', 'discount', 'd1', 'd2', 'total', 'price_item', 'comment', 'my_company'];

	public function parent()
	{
		return $this->hasOne('App\Modules\Operations\Order','id','order_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Modules\Base\Table','category_id');
	}
	public function sub_category()
	{
		return $this->belongsTo('App\Modules\Base\Table','sub_category_id');
	}
	public function product()
	{
		return $this->hasOne('App\Modules\Storage\Product','id','product_id');
	}
	public function unit()
	{
		return $this->hasOne('App\Modules\Base\Table','id','unit_id');
	}
	public function moves()
	{
		return $this->morphMany('App\Modules\Storage\Move', 'move');
	}
}