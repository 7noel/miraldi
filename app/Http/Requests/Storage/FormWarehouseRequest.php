<?php namespace App\Http\Requests\Storage;

use App\Http\Requests\Request;

class FormWarehouseRequest extends Request {

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
		$data=Request::route()->parameters();
		//dd($data);
		return [
			'name'=>'required|unique:warehouses,name'.( (empty($data)) ? '' : ','.$data['warehouse']) ,
			'address'=>'required',
			'ubigeo_id'=>'required|numeric'
		];
	}

}
