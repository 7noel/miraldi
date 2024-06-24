<?php namespace App\Modules\Operations;

use App\Modules\Base\BaseRepo;
use App\Modules\Operations\Modelo;
use App\Modules\Storage\Warehouse;

class ModeloRepo extends BaseRepo{

	public function getModel(){
		return new Modelo;
	}
	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return Modelo::$filter($search)->with('brand')->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Modelo::with('brand')->orderBy('id', 'DESC')->paginate();
		}
	}
	public function modelosByWarehouse($warehouse_id)
	{
		$bs = Warehouse::find($warehouse_id)->company->brands->sortBy('name');
		$r = [];
		foreach ($bs as $key => $b) {
			$ms = $b->modelos->sortBy('name');
			foreach ($ms as $key2 => $m) {
				$r[$b->name][$m->id] = $m->name;
			}
		}

		return $r;
		if (\Request::ajax()) {
			return Modelo::where('brand_id' ,$modelo->brand_id)->orderBY('code', 'ASC')->get();
		}
		return ['' => 'Seleccionar']+Modelo::where('brand_id' ,$modelo->brand_id)->orderBY('code', 'ASC')->pluck('code', 'code')->toArray();
	}

	public function getListGroup($group, $name='name', $id='id')
	{
		$r = [];
		foreach ($this->model->with($group)->get() as $key => $u) {
			$r[$u->$group->name][$u->$id] = $u->$name;
		}
		if (count($r)==1) {
			return $r;
		} else {
			return [''=>'Seleccionar'] + $r;
		}
		
	}
}