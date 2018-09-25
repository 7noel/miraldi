<?php
// Canje de Letras
namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Swap extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['currency_id', 'is_cancel', 'amount_proofs', 'amount_letters'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%");
		}
	}

	public function proofs()
	{
		return $this->hasMany('App\Modules\Finances\Proof');
	}

}