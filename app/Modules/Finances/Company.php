<?php namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['company_name', 'brand_name', 'name', 'paternal_surname', 'maternal_surname', 'id_type', 'doc', 'code', 'address', 'ubigeo_code', 'phone', 'mobile', 'email', 'contact', 'comment', 'config', 'birth', 'country', 'entity_type', 'gender', 'company_id', 'my_company', 'job_id'];
	protected $casts = [
		'config' => 'array',
	];

	public function ubigeo()
	{
		return $this->belongsto('App\Modules\Base\Ubigeo', 'ubigeo_code', 'code');
	}	
	public function my_company()
	{
		return $this->belongsto('App\Modules\Finances\Company', 'my_company');
	}
	public function my_companies()
	{
		return $this->hasMany('App\Modules\Finances\Company', 'my_company');
	}

	public function job()
	{
		return $this->belongsTo('App\Modules\Base\Table','job_id');
	}
	public function company()
	{
		return $this->belongsto('App\Modules\Finances\Company', 'company_id');
	}
	public function branches()
	{
		return $this->hasMany('App\Modules\Finances\Company', 'company_id');
	}
	public function cars()
	{
		return $this->hasMany('App\Modules\Operations\Car', 'company_id');
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
