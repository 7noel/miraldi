<?php namespace App\Modules\Security;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements Auditable {
// class User extends Authenticatable implements Auditable, MustVerifyEmail {

    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'remember_token', 'is_superuser'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function setPasswordAttribute($value){
		if (!empty($value)) {
			if (\Hash::needsRehash($value)){
				$this->attributes['password'] = \Hash::make($value);
			}
		}
	}

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('name', 'LIKE', "%$name%");
		}
	}
	public function roles()
	{
		return $this->belongsToMany('App\Modules\Security\Role')->withTimestamps();
	}
	public function permissions()
	{
		return $this->hasManyThrough('App\Modules\Security\Permission', 'App\Modules\Security\Role', 'user_id', 'role_id');
	}
	public function employee()
	{
		return $this->hasOne('App\Modules\Finances\Company', 'user_id');
		//return $this->belongsto('App\Modules\HumanResources\Employee', 'id', 'user_id');
	}
	public function comments()
    {
        return $this->hasMany('App\Modules\Base\Comment');
    }

	public function action_allowed($action)
    {
    	$join = \DB::table('permissions')
			->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
			->join('role_user', 'role_user.role_id', '=', 'permission_role.role_id')
			->where('role_user.user_id', $this->id)
			->where('permissions.action', $action)
			->select('permissions.id', 'permissions.action')
			->get();
		if ($join->isNotEmpty()) {
			return true;
		}
		return false;

    }

    public function getMyPermissions()
    {
    	$join = \DB::table('permissions')
			->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
			->join('role_user', 'role_user.role_id', '=', 'permission_role.role_id')
			->where('role_user.user_id', $this->id)
			->select('permissions.id', 'permissions.action')
			->get();
    	return $join;
    }
}
