<?php namespace App\Modules\Security;


use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['name', 'description'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	public function permissions()
	{
		return $this->belongsToMany('App\Modules\Security\Permission', 'role_permissions')->withTimestamps();
	}
	public function users()
	{
		return $this->belongsToMany('App\Modules\Security\User', 'user_roles')->withTimestamps();
	}

}
