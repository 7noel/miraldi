<?php

namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Base\UbigeoRepo;
use App\Modules\Base\TableRepo;

use App\Http\Requests\Finances\FormCompanyRequest;

class CompanyController extends Controller {

	protected $repo;
	protected $ubigeoRepo;
	protected $tableRepo;
	protected $idTypeRepo;

	public function __construct(CompanyRepo $repo, UbigeoRepo $ubigeoRepo, TableRepo $tableRepo) {
		$this->repo = $repo;
		$this->ubigeoRepo = $ubigeoRepo;
		$this->tableRepo = $tableRepo;
	}

	public function register()
	{
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		return view('partials.create', compact('ubigeo'));
	}

	public function my_company()
	{
		$id = 1;
		$model = $this->repo->findOrFail($id);
		// dd($model);
		$jobs = $this->tableRepo->getListType('jobs');
		$ubigeo = $this->ubigeoRepo->listUbigeo($model->ubigeo_code);
		return view('finances.companies.edit', compact('model', 'ubigeo', 'jobs'));
	}
	public function save_my_company($id)
	{
		$id = 1;
		$data = request()->all();
		//dd($data);
		
		$this->repo->save($data, $id);
		return redirect()->to('/');
		// if (isset($data['last_page']) && $data['last_page'] != '') {
		// 	return redirect()->to($data['last_page']);
		// }
		// return redirect()->route($this->getType().'.index');
	}

	public function index()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$jobs = $this->tableRepo->getListType('jobs');
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		return view('partials.create', compact('ubigeo', 'jobs'));
	}

	public function store(FormCompanyRequest $request)
	{
		$data = request()->all();
		$this->repo->save($data);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return redirect()->to($data['last_page']);
		}
		return redirect()->route($this->getType().'.index');
	}

	public function show($id)
	{
		$model = $this->repo->findOrFail($id);
		$jobs = $this->tableRepo->getListType('jobs');
		$ubigeo = $this->ubigeoRepo->listUbigeo($model->ubigeo_code);
		return view('partials.show', compact('model', 'jobs', 'ubigeo'));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$jobs = $this->tableRepo->getListType('jobs');
		$ubigeo = $this->ubigeoRepo->listUbigeo($model->ubigeo_code);
		return view('partials.edit', compact('model', 'ubigeo', 'jobs'));
	}

	public function update($id, FormCompanyRequest $request)
	{
		$data = request()->all();
		// dd($data);
		
		$this->repo->save($data, $id);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return redirect()->to($data['last_page']);
		}
		return redirect()->route($this->getType().'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route($this->getType().'.index');
	}
	public function ajaxAutocomplete($type = '', $my_company = '')
	{
		$term = request()->get('term');
		$models = $this->repo->autocomplete($type, $my_company, $term);
		$result = $models->map(function ($model){
			return [
				'value' => $model->company_name,
				'id' => $model->id,
				'country' =>$model->country,
				'company_name' =>$model->company_name,
				'email' =>$model->email,
				'phone' =>$model->phone,
				'mobile' =>$model->mobile,
				'id_type' =>$model->id_type,
				'label' => config('options.client_doc.'.$model->id_type).' '.$model->doc.' '.$model->company_name,
				'branches' => $model->branches->map(function ($branch){
					return ['id' => $branch->id, 'company_name' => $branch->company_name];
				})
			];
		});
		return response()->json($result);
	}
	public function getType()
	{
		return explode('.', request()->route()->getName())[0];
	}
}
