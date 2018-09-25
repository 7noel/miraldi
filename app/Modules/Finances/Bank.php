<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['label', 'number', 'CCI', 'company_id', 'currency_id', 'value'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('label', 'LIKE', "%$name%");
		}
	}

	public function payments()
	{
		return $this->hasMany('App\Modules\Finances\Payment');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}
	public function company()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','company_id');
	}
}