<?php namespace App\Modules\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Modelo extends Model implements Auditable {

	use SoftDeletes;
	use \OwenIt\Auditing\Auditable;

	protected $fillable = ['name', 'description', 'brand_id'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	
	public function brand()
	{
		return $this->belongsto('App\Modules\Operations\Brand');
	}

}
