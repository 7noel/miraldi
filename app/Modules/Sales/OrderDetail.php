<?php

namespace App\Modules\Sales;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['order_id', 'product_id', 'unit_id', 'price', 'value', 'quantity', 'discount', 'total', 'comment'];

	public function parent()
	{
		return $this->hasOne('App\Modules\Sales\Order','id','order_id');
	}
	public function product()
	{
		return $this->hasOne('App\Modules\Storage\Product','id','product_id');
	}
	public function unit()
	{
		return $this->hasOne('App\Modules\Storage\Unit','id','unit_id');
	}
	public function moves()
	{
		return $this->morphMany('App\Modules\Storage\Move', 'move');
	}
}