<?php
// Canje de Letras
namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Swap extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['my_company', 'company_id', 'is_output', 'currency_id', 'is_cancel', 'amount_proofs', 'amount_letters', 'my_company'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%");
		}
	}

	public function proofs()
	{
		return $this->hasMany('App\Modules\Finances\Proof');
	}
	public function letters()
	{
		return $this->hasMany('App\Modules\Finances\Proof', 'swap_letter_id');
	}
	public function mycompany()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','my_company');
	}
	public function company()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','company_id');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}

}