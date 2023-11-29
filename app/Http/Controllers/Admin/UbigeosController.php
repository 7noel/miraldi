<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modules\Base\UbigeoRepo;

class UbigeosController extends Controller{

	protected $ubigeoRepo;

	public function __construct(UbigeoRepo $ubigeoRepo) {
		$this->ubigeoRepo = $ubigeoRepo;
	}
	public function ajaxProvincias($departamento)
	{
		$provincias = $this->ubigeoRepo->ajaxProvincias($departamento);
		return response()->json($provincias);
	}
	public function ajaxDistritos($departamento,$provincia)
	{
		$distritos = $this->ubigeoRepo->ajaxDistritos($provincia);
		return response()->json($distritos);
	}
	public function ajaxDistritos2($departamento,$provincia)
	{
		$distritos = $this->ubigeoRepo->ajaxDistritos2($provincia);
		return response()->json($distritos);
	}
	public function ajaxGetDataUbigeo($code)
	{
		return response()->json($this->ubigeoRepo->findByCode($code));
	}
	public function autocompleteAjax($value='')
	{
		$term = request()->input('term');
		$models = $this->ubigeoRepo->autocomplete($term);
		$result = [];
		foreach ($models as $model) {
			$result[]=[
				'value' => $model->departamento.' - '.$model->provincia.' - '.$model->distrito,
				'id' => $model->code,
				'label' => $model->departamento.' - '.$model->provincia.' - '.$model->distrito,
			];
		}
		return response()->json($result);
	}
}