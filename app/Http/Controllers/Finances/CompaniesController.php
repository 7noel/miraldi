<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Base\IdTypeRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Base\UbigeoRepo;
use App\Modules\Base\SunatRepo;

use App\Http\Requests\Finances\FormCompanyRequest;

class CompaniesController extends Controller {

	protected $repo;
	protected $ubigeoRepo;
	protected $sunatRepo;
	protected $idTypeRepo;

	public function __construct(CompanyRepo $repo, UbigeoRepo $ubigeoRepo, IdTypeRepo $idTypeRepo, SunatRepo $sunatRepo) {
		$this->repo = $repo;
		$this->ubigeoRepo = $ubigeoRepo;
		$this->idTypeRepo = $idTypeRepo;
		$this->sunatRepo = $sunatRepo;
	}

	public function index()
	{
		// set_time_limit(0);
  //       $ar = ['20338896825'];
  //       foreach ($ar as $key => $a) {
  //           $p = json_decode(file_get_contents("http://api.noelhh.com/sunat/ruc/$a"), true);
  //           $data['company_name'] = $p['razon_social'];
  //           $data['id_type_id'] = 1;
  //           $data['doc'] = $p['ruc'];
  //           $data['address'] = $p['direccion'];
  //           $data['ubigeo_id'] = $p['ubigeo']['id'];
  //           $data['country_id'] = 1465;
  //           $data['brand_name'] = "";
	 //        $data['paternal_surname'] = "";
	 //        $data['maternal_surname'] = "";
  //           $this->repo->save($data);
  //       }
  //       dd("listo");
		$models = $this->repo->index('name', \Request::get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$id_types = $this->idTypeRepo->getList('symbol');
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		$countries = $this->sunatRepo->getList2('FE', 4);
		return view('partials.create', compact('id_types', 'ubigeo', 'countries'));
	}

	public function store(FormCompanyRequest $request)
	{
		$data = \Request::all();
		$this->repo->save($data);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return \Redirect::to($data['last_page']);
		}
		return \Redirect::route('companies.index');
	}

	public function show($id)
	{
		$id_types = $this->idTypeRepo->getList('symbol');
		$model = $this->repo->findOrFail($id);
		$ubigeo = $this->ubigeoRepo->listUbigeo($model->ubigeo_id);
		$countries = $this->sunatRepo->getList2('FE', 4);
		return view('partials.show', compact('model', 'id_types', 'ubigeo'));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$id_types = $this->idTypeRepo->getList('symbol');
		$ubigeo = $this->ubigeoRepo->listUbigeo($model->ubigeo_id);
		$countries = $this->sunatRepo->getList2('FE', 4);
		return view('partials.edit', compact('model', 'id_types', 'ubigeo', 'countries'));
	}

	public function update($id, FormCompanyRequest $request)
	{
		$data = \Request::all();
		$this->repo->save($data, $id);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return \Redirect::to($data['last_page']);
		}
		return \Redirect::route('companies.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route('companies.index');
	}
	public function ajaxAutocomplete()
	{
		$term = \Input::get('term');
		$models = $this->repo->autocomplete($term);
		$result = [];
		foreach ($models as $model) {
			$result[]=[
				'value' => $model->company_name,
				'id' => $model->id,
				'country_id' =>$model->country_id,
				'label' => $model->id_type->symbol.' '.$model->doc.' '.$model->company_name
			];
		}
		return \Response::json($result);
	}
}
