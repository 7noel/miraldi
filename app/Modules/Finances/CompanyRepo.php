<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Company;

class CompanyRepo extends BaseRepo{

	public function getModel(){
		return new Company;
	}

	public function index($filter = false, $search = false)
	{
		$type = explode('.', \Request::route()->getName())[0];
		if ($filter and $search) {
			return Company::where('entity_type', $type)->$filter($search)->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Company::where('entity_type', $type)->orderBy('id', 'DESC')->paginate();
		}
	}
	
	public function autocomplete($type, $my_company, $term)
	{
		$matriz = array('clients', 'shippers', 'providers', 'my_company');
		if (in_array($type, $matriz)) {
			return Company::where('my_company', $my_company)->where('entity_type', $type)->where(function ($query) use ($term) {$query->where('company_name','like',"%$term%")->orWhere('doc','like',"%$term%");})->with('branches')->get();
		} else {
			return Company::where('my_company', $my_company)->where('company_name','like',"%$term%")->orWhere('doc','like',"%$term%")->with('branches')->get();
		}
	}
		// } elseif ($type == 'shippers') {
		// 	return Company::where('is_shipper', '=', 1)->where(function ($query) use ($term) {$query->where('company_name','like',"%$term%")->orWhere('doc','like',"%$term%");})->with('id_type')->get();
		// } elseif ($type == 'providers') {
		// 	return Company::where('is_provider', '=', 1)->where(function ($query) use ($term) {$query->where('company_name','like',"%$term%")->orWhere('doc','like',"%$term%");})->with('id_type')->get();
		// } elseif ($type == 'my_company') {
		// 	return Company::where('is_my_company', '=', 1)->where(function ($query) use ($term) {$query->where('company_name','like',"%$term%")->orWhere('doc','like',"%$term%");})->with('id_type')->get();
		
	public function prepareData($data)
	{
		//dd($data);
		if ($data['entity_type'] != 'employees') {
			if ($data['entity_type'] != 'branches') {
				$data['brand_name'] = trim($data['brand_name']);
			}
			$data['company_name'] = trim($data['company_name']);
		}
		if (in_array($data['id_type'], ['1','4','7','A'])) {
			$data['paternal_surname'] = trim($data['paternal_surname']);
			$data['maternal_surname'] = trim($data['maternal_surname']);
			$data['company_name'] = $data['paternal_surname'].' '.$data['maternal_surname'].' '.$data['name'];
		}
		if (isset($data['country']) and $data['country'] != 'PE') {
			$data['ubigeo_code'] = '000000';
		}
		if (isset($data['branches'])) {
			foreach ($data['branches'] as $key => $value) {
				$data['branches'][$key]['entity_type'] = 'branches';
				$data['branches'][$key]['my_company'] = session('my_company')->id;
			}
		}
		return $data;
	}

	public function save($data, $id=0)
	{
		$data['entity_type'] = explode('.', \Request::route()->getName())[0];
		$data = $this->prepareData($data);
		if (isset($data['config']['logo'])) {
			$data['config']['logo'] = $this->saveFile('storage', $data['config']['logo']);
		} elseif (isset($data['temporal']['logo'])) {
			$data['config']['logo'] = $data['temporal']['logo'];
		}
		if (isset($data['config']['favicon'])) {
			$data['config']['favicon'] = $this->saveFile('storage', $data['config']['favicon']);
		} elseif (isset($data['temporal']['favicon'])) {
			$data['config']['favicon'] = $data['temporal']['favicon'];
		}
		
		$model = parent::save($data, $id);
		// dd($data['brand_name']);

		if (isset($data['branches'])) {
			// $branchRepo= new CompanyRepo;
			// $branchRepo->saveMany($data['branches'], ['key'=>'company_id', 'value'=>$model->id]);
			parent::saveMany2($data['branches'], ['key'=>'company_id', 'value'=>$model->id]);
		}

		return $model;
	}

	public function getListMyCompany()
	{
		return [""=>"Seleccionar"] + Company::where('entity_type', 'companies')->pluck('company_name', 'id')->toArray();
	}
	public function getOtherCompanies($id=1)
	{
		return Company::where('entity_type', 'my_company')->where('id', '!=', $id)->get();
	}
	public function getListSellers()
	{
		return Company::where('entity_type', 'employees')->where('my_company', session('my_company')->id)->where('job_id', config('options.seller_id'))->pluck('company_name', 'id')->toArray();
	}
	public function getListRepairmens()
	{
		return Company::where('entity_type', 'employees')->where('my_company', session('my_company')->id)->where('job_id', config('options.repairman_id'))->pluck('company_name', 'id')->toArray();
	}
}