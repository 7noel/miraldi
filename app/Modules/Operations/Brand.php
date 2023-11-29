<?php namespace App\Modules\Operations;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['name', 'description', 'is_car', 'my_company'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	
	public function modelos()
	{
		return $this->hasMany('App\Modules\Operations\Modelo');
	}
	public function companies()
	{
		return $this->belongsToMany('App\Modules\Finances\Company');
	}
}
