<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amortization extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['label', 'value_proof', 'value_payment', 'proof_id', 'payment_id', 'my_company'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('label', 'LIKE', "%$name%");
		}
	}

	public function payment()
	{
		return $this->belongsto('App\Modules\Finances\Payment');
	}
	public function proof()
	{
		return $this->belongsto('App\Modules\Finances\Proof');
	}
}