<?php 

namespace App\Modules\Security;

use App\Modules\Base\BaseRepo;
use App\Modules\Security\PermissionGroup;

class PermissionGroupRepo extends BaseRepo{

	public function getModel(){
		return new PermissionGroup;
	}

	public function findOrFail($id){
		return PermissionGroup::findOrFail($id);
	}

	public function getList($name='name', $id='id')
	{
		return $list = [""=>'Seleccionar'] + $this->model->pluck($name, $id)->toArray();
	}

	public function all()
	{
		return PermissionGroup::has('permissions')->with('permissions')->get();
	}
}