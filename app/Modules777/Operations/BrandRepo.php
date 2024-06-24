<?php namespace App\Modules\Operations;

use App\Modules\Base\BaseRepo;
use App\Modules\Operations\Brand;
use App\Modules\Operations\ModeloRepo;

class BrandRepo extends BaseRepo{

	public function getModel(){
		return new Brand;
	}

	public function prepareData($data)
	{
		// dd($data);
		if (!isset($data['is_car'])) {
			$data['is_car'] = false;
		}
		return $data;
	}

	public function getList2($name='name', $id='id')
	{
		return Brand::where('is_car',true)->pluck($name, $id)->toArray();
	}
	public function save($data, $id=0){
		$data = $this->prepareData($data);
		$modeloRepo= new ModeloRepo;
		$model = parent::save($data, $id);
		if (isset($data['modelos'])) {
			$modeloRepo->saveMany2($data['modelos'], ['key' => 'brand_id', 'value' => $model->id]);
		}
		return $model;
	}

}