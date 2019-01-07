<?php namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['company_name', 'brand_name', 'name', 'paternal_surname', 'maternal_surname', 'id_type_id', 'doc', 'address', 'ubigeo_id', 'phone', 'mobile', 'email', 'contact', 'comment', 'birth', 'is_client', 'is_provider','is_my_company', 'is_shipper', 'country_id', 'bank_bcp', 'bank_other'];

	public function id_type()
    {
        return $this->belongsto('App\Modules\Base\IdType');
    }
	public function ubigeo()
	{
		return $this->belongsto('App\Modules\Base\Ubigeo');
	}
	public function country()
	{
		return $this->hasOne('App\Modules\Base\SunatTable','id','country_id');
	}

	public function scopeName($query, $name){
		if (trim($name) != "") {
			// $query->where(function ($q) use ($a,$b) {
			// 	$q->where('a', '=', $a)
			// 		->orWhere('b', '=', $b);
			// });
			$query->where('company_name', 'LIKE', "%$name%")->orWhere('doc', 'LIKE', "%$name%");
		}
	}
}
