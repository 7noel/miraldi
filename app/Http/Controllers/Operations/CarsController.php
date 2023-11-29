<?php namespace App\Http\Controllers\Operations;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Operations\BrandRepo;
use App\Modules\Operations\ModeloRepo;
use App\Modules\Operations\CarRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Base\UbigeoRepo;

class CarsController extends Controller {

	protected $repo;
	protected $brandRepo;
	protected $modeloRepo;
	protected $companyRepo;
	protected $ubigeoRepo;

	public function __construct(CompanyRepo $companyRepo, CarRepo $repo, BrandRepo $brandRepo, ModeloRepo $modeloRepo, UbigeoRepo $ubigeoRepo) {
		$this->repo = $repo;
		$this->brandRepo = $brandRepo;
		$this->modeloRepo = $modeloRepo;
		$this->companyRepo = $companyRepo;
		$this->ubigeoRepo = $ubigeoRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$bodies = config('options.bodies');
		$modelos = $this->modeloRepo->getListGroup('brand');
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		return view('partials.create', compact('modelos', 'bodies', 'ubigeo'));
	}

	public function createByClient($client_id)
	{
		$client = $this->companyRepo->find($client_id);
		$bodies = config('options.bodies');
		$modelos = $this->modeloRepo->getListGroup('brand');
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		// return redirect()->route('cars.add', $client);
		return view('partials.create', compact('client', 'modelos', 'bodies', 'ubigeo'));
	}

	public function store()
	{
		$this->repo->save(request()->all());
		if (isset($data['last_page'])) {
			return redirect($data['last_page']);
		}
		return redirect()->route('cars.index');
	}

	public function show($id)
	{
		$model = $this->repo->findOrFail($id);
		$modelos = $this->modeloRepo->getListGroup('brand');
		$bodies = config('options.bodies');
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		return view('partials.show', compact('model', 'modelos', 'bodies', 'ubigeo'));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$modelos = $this->modeloRepo->getListGroup('brand');
		$bodies = config('options.bodies');
		$ubigeo = $this->ubigeoRepo->listUbigeo();
		return view('partials.edit', compact('model', 'modelos', 'bodies', 'ubigeo'));
	}

	public function update($id)
	{
		// dd(request()->all());
		$data = request()->all();
		$this->repo->save($data, $id);
		if (isset($data['last_page'])) {
			return redirect($data['last_page']);
		}
		return redirect()->route('cars.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('operations.cars.index');
	}

	public function modelosByWarehouse($warehouse_id)
	{
		$modelos = $this->modeloRepo->modelosByWarehouse($warehouse_id);
		return response()->json($modelos);
	}
	public function getCar($placa)
	{
		$model = $this->repo->getCar($placa);
		return response()->json($model);
	}
	public function reportNacimiento()
	{
		$filter = (object) request()->all();
		if( !((array) $filter) ) {
			$filter->f1 = date('m', strtotime("+ 1 month"));
		}
		$models = $this->repo->filter($filter);
		//dd($models);

		return view('operations.cars.filter',compact('models', 'filter'));
	}
	public function generateSlug()
	{
		$cars = $this->repo->withoutSlug();
		//dd($cars);
		foreach ($cars as $key => $car) {
			// $car->slug = bin2hex(random_bytes($value));
			$car->slug = 24;
			$car->save();
		}
		return 'Fin';
	}
}