<?php

namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['issued_at', 'company_id', 'number', 'is_output', 'value', 'exchange', 'bank_id', 'currency_id', 'tipo_operacion', 'cta_origen', 'cta_destino', 'titular_destino', 'currency2_id', 'monto'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%");
		}
	}

	public function bank()
	{
		return $this->belongsTo('App\Modules\Finances\Bank');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}
	public function amortizations()
	{
		return $this->hasMany('App\Modules\Finances\Amortization');
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