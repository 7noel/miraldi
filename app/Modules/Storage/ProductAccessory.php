<?php

namespace App\Modules\Storage;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAccessory extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['product_id', 'accessory_id'];

	public function product()
	{
		return $this->hasOne('App\Modules\Storage\Product','id','product_id');
	}
	public function accessory()
	{
		return $this->hasOne('App\Modules\Storage\Product','id','accessory_id');
	}
}
