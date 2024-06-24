<?php namespace App\Modules\Storage;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['name', 'address', 'ubigeo_code', 'my_company'];

    public function ubigeo()
	{
		return $this->belongsTo('App\Modules\Base\Ubigeo','ubigeo_code','code');
	}

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	public function stocks()
	{
		return $this->hasMany('App\Modules\Storage\Stock');
	}
}