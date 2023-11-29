<?php 

namespace App\Modules\Security;

use App\Modules\Base\BaseRepo;
use App\Modules\Security\Role;

class RoleRepo extends BaseRepo{

	public function getModel(){
		return new Role;
	}

	public function findOrFail($id){
		return Role::findOrFail($id);
	}

	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return Role::$filter($search)->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Role::orderBy('id', 'DESC')->paginate();
		}
	}

	public function save($data, $id=0)
	{
		$model = parent::save($data,$id);
		if (!isset($data['permissions'])) {
			$data['permissions'] = [];
		}
		$model->permissions()->sync($data['permissions']);
		
		return $model;
	}
}