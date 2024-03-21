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
		//$id_type = \Request::only('CTIPO_DOCUMENTO')['CTIPO_DOCUMENTO'];
		$data = array_values(\Request::route()->parameters());
		$id = array_shift($data) ?? null;

		// switch ($id_type) {
		// 	case '6':
		// 		$rules = 'digits:11';
		// 		break;
		// 	case '1':
		// 		$rules = 'digits:8';
		// 		break;
		// 	default:
		// 		if(is_numeric(\Request::only('TRACODIGO')['TRACODIGO'])){ $rules = 'digits_between:6,11'; }
		// 		else { $rules = 'between:6,11'; }
		// 		break;
		// }

		//dd();
		return [
				//'CTIPO_DOCUMENTO'=>['required', Rule::in(array_keys(config('options.client_doc')))],
				'TRACODIGO' => ['digits:11', 'required', Rule::unique('sqlsrv.MAETRAN', 'TRACODIGO')->ignore($id, 'TRACODIGO')],
				'TRARAZEMP'=>'required',
				//'CPRIMER_NOMBRE'=>'required_if:CTIPO_DOCUMENTO,1,4,7,A',
				//'CAPELLIDO_PATERNO'=>'required_if:CTIPO_DOCUMENTO,1,4,7,A',
				'TRADIR'=>'required',
				//'UBIGEO'=>'required',
				//'CTELEFO'=>'required',
				//'email'=>'email',
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
