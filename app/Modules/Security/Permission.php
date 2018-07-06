<?php namespace App\Modules\Security;


use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['name', 'action', 'description', 'permission_group_id'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	public function permission_group()
	{
		return $this->belongsTo('App\Modules\Security\PermissionGroup');
	}
	public function roles()
    {
        return $this->belongsToMany('App\Modules\Security\Role', 'role_permissions');
    }
}
