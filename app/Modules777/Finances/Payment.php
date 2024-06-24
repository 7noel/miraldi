<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['issued_at', 'metodo', 'company_id', 'number', 'is_output', 'value', 'exchange', 'proof_id', 'bank_id', 'currency_id', 'input', 'output', 'my_company'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%");
		}
	}

	public function proof()
	{
		return $this->belongsTo('App\Modules\Finances\Proof');
	}
	public function bank()
	{
		return $this->belongsTo('App\Modules\Finances\Bank');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}
	public function mycompany()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','my_company');
	}
	public function company()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','company_id');
	}

}