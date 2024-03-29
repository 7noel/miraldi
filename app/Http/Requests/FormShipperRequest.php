<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FormShipperRequest extends Request {

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
		$data = array_values(\Request::route()->parameters());
		$id = array_shift($data) ?? null;

		return [
				'TRACODIGO' => ['digits:11', 'required', Rule::unique('sqlsrv.MAETRAN', 'TRACODIGO')->ignore($id, 'TRACODIGO')],
				'TRARAZEMP'=>'required',
				'TRADIR'=>'required',
			];
	}
	
	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array<string, string>
	 */
	public function attributes(): array
	{
	    return [
	        'TRACODIGO' => 'RUC',
	        'TRARAZEMP' => 'Razón Social',
	        'TRADIR' => 'Dirección',
	    ];
	}

}
