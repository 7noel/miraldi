<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProofDetail extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['proof_id', 'product_id', 'stock_id', 'unit_id', 'quantity', 'discount', 'price', 'total', 'cost', 'value', 'd1', 'd2', 'igv_code'];

	public function parent()
	{
		return $this->hasOne('App\Modules\Logistics\Purchase','id','proof_id');
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
}
