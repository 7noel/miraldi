<?php namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['fecha', 'my_company', 'venta', 'compra'];

	public function scopeFecha($query, $name){
		if (trim($name) != "") {
			$query->where('fecha', 'LIKE', "%$name%");
		}
	}
}
