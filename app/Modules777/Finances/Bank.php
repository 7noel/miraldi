<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['show', 'type', 'name', 'number', 'cci', 'initial', 'total', 'currency_id', 'description', 'my_company'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('label', 'LIKE', "%$name%");
		}
	}

	public function payments()
	{
		return $this->hasMany('App\Modules\Finances\Payment')->orderBy('created_at', 'desc');
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