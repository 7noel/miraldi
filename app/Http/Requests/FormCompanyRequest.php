<?php namespace App\Http\Requests;

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
		$id_type = \Request::only('CTIPO_DOCUMENTO')['CTIPO_DOCUMENTO'];
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
				if(is_numeric(\Request::only('CCODCLI')['CCODCLI'])){ $rules = 'digits_between:6,11'; }
				else { $rules = 'between:6,11'; }
				break;
		}

		//dd();
		return [
				'CTIPO_DOCUMENTO'=>['required', Rule::in(array_keys(config('options.client_doc')))],
				'CCODCLI' => [$rules, 'required', Rule::unique('sqlsrv.MAECLI', 'CCODCLI')->ignore($id, 'CCODCLI')],
				'CNOMCLI'=>'required_if:CTIPO_DOCUMENTO,0,-,6',
				'CPRIMER_NOMBRE'=>'required_if:CTIPO_DOCUMENTO,1,4,7,A',
				'CAPELLIDO_PATERNO'=>'required_if:CTIPO_DOCUMENTO,1,4,7,A',
				'CDIRCLI'=>'required',
				'UBIGEO'=>'required',
				'CTELEFO'=>'required',
				'CEMAIL'=>'email',
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
	        'CTIPO_DOCUMENTO' => 'Tipo Documento',
	        'CCODCLI' => 'Documento',
	        'CNOMCLI' => 'Razón Social',
	        'CPRIMER_NOMBRE' => 'Nombre',
	        'CAPELLIDO_PATERNO' => 'Apellido Paterno',
	        'CDIRCLI' => 'Dirección',
	        'UBIGEO' => 'Dirección',
	        'CTELEFO' => 'Celular',
	        'CEMAIL' => 'Email',
	    ];
	}

}
