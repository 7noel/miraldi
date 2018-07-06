<?php 

namespace App\Modules\Base;

abstract class BaseRepo{

	protected $model;

	public function __construct() {
		$this->model = $this->getModel();
	}

	abstract public function getModel();
	
	public function find($id){
		return $this->model->find($id);
	}
	public function findOrFail($id){
		return $this->model->findOrFail($id);
	}
	public function firstOrCreate($atributes, $values){
		return $this->model->firstOrCreate($atributes, $values);
	}
	public function all()
	{
		return $this->model->all();
	}
	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return $this->model->$filter($search)->orderBy("$filter", 'ASC')->paginate();
		} else {
			return $this->model->orderBy('id', 'DESC')->paginate();
		}
	}

	public function getList($name='name', $id='id')
	{
		return $list = [""=>'Seleccionar'] + $this->model->pluck($name, $id)->toArray();
	}
	public function getListGroup($group, $name='name', $id='id')
	{
		foreach ($this->model->with($group)->get() as $key => $u) {
			$r[$u->$group->name][$u->$id] = $u->$name;
		}
		if (isset($r)) {
			return [''=>'Seleccionar'] + $r;
		} else {
			return [''=>'Seleccionar'];
		}
		
	}
	public function all_with_deleted()
	{
		return $this->model->withTrashed()->get();
	}
	public function all_only_deleted()
	{
		return $this->model->onlyTrashed()->get();
	}
	public function jsonArray($array,$value,$label)
	{
		foreach ($array as $valor) {
			$data[]=array("value"=>$valor[$value],
				'label'=>$valor[$label],
				'id'=>$valor
			);
		}
		return Response::json($data);
	}
	public function destroy($id)
	{
		$model=$this->model->findOrFail($id);
		$model->delete();
		$message = $model->name. ' fue eliminado';
		if (\Request::ajax()) {
			return response()->json([
				'id'=>$model->id,
				'message'=>$message
			]);
		}
		\Session::flash('message', $message);
		return $model;
	}
	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		return $this->model->updateOrCreate([$this->model->getKeyName() => $id], $data);
	}
	public function prepareData($data)
	{
		return $data;
	}
	/**
	 * Graba varias items hijos de 2 tablas padres. Para eliminar se debe enviar el campo is_deleted
	 * @param  [array] $allData [contiene los elementos a ingresar]
	 * @param  [array] $k1      [tiene key y value del padre desde donde ingresa]
	 * @param  [string] $k2      [nombre del key de los items]
	 * @param  [array] $k3      [tiene key y value del tipo de modelo en un polimorfismo]
	 * @return [array]          [retorna los ids de los elementos eliminados]
	 */
	public function syncMany($allData,$k1,$k2,$k3=[])
	{
		$toSave = [];
		$toEdit = [];
		$toDelete = [];
		foreach ($allData as $key => $data) {
			if (isset($data['is_deleted'])) {
				if (isset($data['id']) and $data['id']>0) {
					# Array con ids a eliminar
					$toDelete[] = $data[$k2];
				}
			} else {
				# Array con data para Agregar
				$toSave[] = $data;
			}
		}
		# Elimina registros
		if (isset($toDelete)) {
			if (empty($k3)) {
				$this->model->where($k1['key'], $k1['value'])->whereIn($k2, $toDelete)->delete();
			} else {
				$this->model->where($k3['key'], $k3['value'])->where($k1['key'], $k1['value'])->whereIn($k2, $toDelete)->delete();
			}
		}
		# Guardar registros
		foreach ($toSave as $key => $data) {
			$data[$k1['key']] = $k1['value'];
			if (empty($k3)) {
				$model = $this->model->updateOrCreate([$k1['key'] => $k1['value'], $k2 => $data[$k2]], $data);
			} else {
				$model = $this->model->updateOrCreate([$k1['key'] => $k1['value'], $k2 => $data[$k2], $k3['key'] => $k3['value']], $data);
			}
			
		}

		return $toDelete;
	}

	/**
	 * Graba varias items hijos de 2 tablas padres
	 * @param  [array] $allData [contiene los elementos a ingresar]
	 * @param  [array] $k1      [tiene key y value del padre desde donde ingresa]
	 * @param  [string] $k2      [nombre del key de los items]
	 * @return [boolean]          [description]
	 */
	public function syncMany_old($allData,$k1,$k2)
	{
		$new_ids = [];
		foreach ($allData as $key => $data) {
			$new_ids[] = $data["$k2"];
		}
		$old_ids = $this->model->where($k1['key'],$k1['value'])->pluck($k2)->toArray();
		$toDelete = array_diff($old_ids, $new_ids);
		$toSave = array_diff($new_ids, $old_ids);
		$toEdit = array_intersect($old_ids, $new_ids);
		if (!empty($toDelete)) {
			$this->model->where($k1['key'], $k1['value'])->whereIn($k2,$toDelete)->delete();
		}
		foreach ($allData as $key => $data) {
			if (in_array($data[$k2], $toSave)) {
				$data[$k1['key']] = $k1['value'];
				$this->save($data);
			} else if (in_array($data[$k2], $toEdit)) {
				$model = $this->model->where($k1['key'],$k1['value'])->where($k2, $data["$k2"])->first();
				$model->fill($data);
				$model->save();
			}
		}
		return true;
	}

	public function saveFile($folder = '', $file, $nameOld = '')
	{
		
		$name = $file->getClientOriginalName();
		if ($nameOld == '') {
			$nameOld = $name;
		}
		if (\Storage::exists($folder.'/'.$nameOld)) {
			\Storage::delete($folder.'/'.$nameOld);
		}
		$i=1;
		while (file_exists($public_path.'/storage/'.$name)) {
			$name = $name."-$i";
			$i++;
		}
		\Storage::disk('local')->put('storage/'.$name,  \File::get($file));
	}
	public function prepareDataImage($data, $images)
	{
		foreach ($images as $key => $image) {
			if (isset($data[$image])) {
				$data[$image] = $data[$image]->getClientOriginalName();
			} else if (isset($data['delete_'.$image])) {
				$data[$image] = '';
			}
			else {
				unset($data[$image]);
			}
		}
		return $data;
	}
	public function saveMany($items, $k)
	{
		foreach ($items as $key => $data) {
			$data = $this->prepareData($data);
			$data[$k['key']] = $k['value'];
			if (isset($data['id'])) {
				$model = $this->findOrFail($data['id']);
				if (trim($data['name']) == '') {
					$model->delete();
				} else {
					$model->fill($data);
					$model->save();
				}
			} else {
				if (trim($data['name']) != '') {
					$this->model->create($data);
				}
			}
		}
	}
}