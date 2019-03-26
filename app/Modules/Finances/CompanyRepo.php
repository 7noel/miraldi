<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Company;
use App\Modules\Finances\BranchRepo;

class CompanyRepo extends BaseRepo{

	public function getModel(){
		return new Company;
	}

	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return Company::where($this->getType(), 1)->$filter($search)->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Company::where($this->getType(), 1)->orderBy('id', 'DESC')->paginate();
		}
	}
	public function autocomplete($term)
	{
		return Company::where('company_name','like',"%$term%")->orWhere('doc','like',"%$term%")->with('id_type')->get();
	}
	public function prepareData($data)
	{
		$data['company_name'] = trim($data['company_name']);
		$data['brand_name'] = trim($data['brand_name']);
		$data['paternal_surname'] = trim($data['paternal_surname']);
		$data['maternal_surname'] = trim($data['maternal_surname']);
		if($data['id_type_id'] != 1 and $data['id_type_id'] != 6){
			$data['company_name'] = $data['paternal_surname'].' '.$data['maternal_surname'].' '.$data['name'];
		}
		if ( $this->getType() ) {
			$data[$this->getType()] = 1;
		}
		// if(!isset($data['is_my_company'])){
		// 	$data['is_my_company'] = false;
		// }
		if (isset($data['country_id']) and $data['country_id'] != 1465) {
			$data['ubigeo_id'] = 1868;
		}
		return $data;
	}

	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		$model = parent::save($data, $id);

		if (isset($data['branches'])) {
			$branchRepo= new BranchRepo;
			$branchRepo->saveMany($data['branches'], ['key'=>'company_id', 'value'=>$model->id]);
		}

		return $model;
	}

	public function getListMyCompany()
	{
		return [""=>"Seleccionar"] + Company::where('is_my_company','1')->pluck('company_name', 'id')->toArray();
	}
	public function getOtherCompanies($id=1)
	{
		return Company::where('is_my_company','1')->where('id', '!=', $id)->get();
	}
	public function getType()
	{
		$a = explode('.', \Request::route()->getName())[0];
		$array = array('clients' => 'is_client', 'providers' => 'is_provider', 'shippers' => 'is_shipper', 'companies' => 'is_my_company');
		if (isset($array[$a])) {
			return $array[$a];
		} else {
			return false;
		}
	}

	
}