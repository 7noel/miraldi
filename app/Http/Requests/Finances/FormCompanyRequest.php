<?php namespace App\Http\Requests\Finances;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FormCompanyRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$entity_type = explode('.', \Request::route()->getName())[0];
		$id_type = \Request::only('id_type')['id_type'];
		$data = array_values(\Request::route()->parameters());
		$id = array_shift($data) ?? null;

		switch ($id_type) {
			case '6':
				$rules = 'digits:11';
				break;
			case '1':
				$rules = 'digits:8';
				break;
			default:
				if(is_numeric(\Request::only('doc')['doc'])){ $rules = 'digits_between:6,11'; }
				else { $rules = 'between:6,11'; }
				break;
		}

		$array = [
			'clients' => [
				'id_type'=>['required', Rule::in(array_keys(config('options.client_doc')))],
				'doc' => [$rules, 'required', Rule::unique('companies')->where(function ($query) use ($id_type, $entity_type){
			            return $query->where('my_company', session('my_company')->id)
			            ->where('id_type', $id_type)
			            ->where('entity_type', $entity_type);
			        })->ignore($id)],
				'company_name'=>'required_if:id_type,0,-,6',
				'name'=>'required_if:id_type,1,4,7,A',
				'paternal_surname'=>'required_if:id_type,1,4,7,A',
				'address'=>'required',
				'ubigeo_code'=>'required_if:country,PE',
				'email'=>'email',
			],
			'providers' => [
				'id_type'=>['required', Rule::in(array_keys(config('options.client_doc')))],
				'doc' => [$rules, 'required', Rule::unique('companies')->where(function ($query) use ($id_type, $entity_type){
			            return $query->where('my_company', session('my_company')->id)
			            ->where('id_type', $id_type)
			            ->where('entity_type', $entity_type);
			        })->ignore($id)],
				'company_name'=>'required_if:id_type,1,6',
				'name'=>'required_if:id_type,1,4,7,A',
				'paternal_surname'=>'required_if:id_type,1,4,7,A',
				'address'=>'required',
				'ubigeo_code'=>'required_if:country,PE',
				'email'=>'email',
			],
			'shippers' => [
				'id_type'=>['required', Rule::in(array_keys(config('options.client_doc')))],
				'doc' => [$rules, 'required', Rule::unique('companies')->where(function ($query) use ($id_type, $entity_type){
			            return $query->where('my_company', session('my_company')->id)
			            ->where('id_type', $id_type)
			            ->where('entity_type', $entity_type);
			        })->ignore($id)],
				'company_name'=>'required_if:id_type,1,6',
				'name'=>'required_if:id_type,1,4,7,A',
				'paternal_surname'=>'required_if:id_type,1,4,7,A',
				'address'=>'required',
				'ubigeo_code'=>'required_if:country,PE',
				'email'=>'email',
			],
			'employees' => [
				'job_id'=>"required|numeric",
				'id_type'=>['required', Rule::in(array_keys(config('options.employee_doc')))],
				'doc' => [$rules, 'required', Rule::unique('companies')->where(function ($query) use ($id_type, $entity_type){
			            return $query->where('my_company', session('my_company')->id)
			            ->where('id_type', $id_type)
			            ->where('entity_type', $entity_type);
			        })->ignore($id)],
				'name'=>'required',
				'paternal_surname'=>'required',
				'address'=>'required',
				'ubigeo_code'=>'required',
				'email'=>'email',
			],
		];
		return $array[$entity_type];
	}

}
