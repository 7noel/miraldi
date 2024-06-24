<?php

namespace App\Modules\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Car extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['company_id', 'my_company', 'placa', 'brand_id', 'modelo_id', 'year', 'version', 'body', 'color', 'vin', 'motor', 'codigo', 'f_revision', 'f_llamada', 'f_recordatorio', 'f_next_pr', 'add_contact', 'contact_name', 'contact_email', 'contact_phone', 'contact_mobile', 'slug'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			return $query->where('placa', 'LIKE', "%$name%")->orWhere('vin', 'LIKE', "%$name%");
		}
	}
	public function setSlugAttribute($value)
	{
		if (!empty($value)) {
			$this->attributes['slug'] = bin2hex(random_bytes($value));
		}
	}
	public function company()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'company_id');
	}
	public function modelo()
	{
		return $this->belongsto('App\Modules\Operations\Modelo');
	}
	public function brand()
	{
		return $this->belongsto('App\Modules\Operations\Brand');
	}
}
