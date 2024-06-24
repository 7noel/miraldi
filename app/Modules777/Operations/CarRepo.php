<?php namespace App\Modules\Operations;

use App\Modules\Base\BaseRepo;
use App\Modules\Operations\Car;

class CarRepo extends BaseRepo{

	public function getModel(){
		return new Car;
	}

	public function getCar($placa)
	{
		return $this->model->where('placa',$placa)->first();
	}
	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return Car::$filter($search)->orderBy("placa", 'ASC')->paginate();
		} else {
			return Car::orderBy('id', 'DESC')->paginate();
		}
	}
	public function prepareData($data)
	{
		if (!isset($data['add_contact'])) {
			$data['add_contact'] = false;
		}
		return $data;
	}
	public function filter($filter)
	{
		return Car::whereHas('company', function ($query) use($filter) {
			    $query->whereMonth('birth', $filter->f1);
			})->with('company', 'modelo.brand')->get();
	}
	public function withoutSlug()
	{
		return Car::where('slug', '')->withTrashed()->get();
	}
}