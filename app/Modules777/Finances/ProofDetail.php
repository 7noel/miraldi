<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProofDetail extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['proof_id', 'product_id', 'stock_id', 'unit_id', 'category_id', 'sub_category_id', 'is_downloadable', 'quantity', 'discount', 'price', 'total', 'price_item', 'cost', 'value', 'd1', 'd2', 'igv_code', 'my_company'];

	public function parent()
	{
		return $this->hasOne('App\Modules\Finances\Proof','id','proof_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Modules\Base\Table','category_id');
	}
	public function sub_category()
	{
		return $this->belongsTo('App\Modules\Base\Table','sub_category_id');
	}
	public function stock()
	{
		return $this->belongsto('App\Modules\Storage\Stock');
	}
	public function product()
	{
		return $this->belongsto('App\Modules\Storage\Product');
	}
	public function moves()
	{
		return $this->morphMany('App\Modules\Storage\Move', 'move');
	}
	public function unit()
	{
		return $this->hasOne('App\Modules\Base\Table','id','unit_id');
	}
}
