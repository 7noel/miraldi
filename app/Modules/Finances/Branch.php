<?php
namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['company_id', 'name', 'address', 'ubigeo_id', 'country_id', 'phone', 'mobile', 'email', 'contact', 'comment'];

	public function company()
	{
		return $this->belongsTo('App\Modules\Finances\Company');
	}
	public function ubigeo()
	{
		return $this->belongsTo('App\Modules\Base\Ubigeo');
	}
	public function country()
	{
		return $this->belongsTo('App\Modules\Base\SunatTable','id','country_id');
	}

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
}
