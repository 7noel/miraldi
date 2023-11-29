<?php namespace App\Http\Controllers\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Base\TableRepo;
use App\Modules\Storage\ProductRepo;
use App\Modules\Storage\StockRepo;
use App\Modules\Storage\Product;
use App\Modules\Storage\MoveRepo;
use App\Modules\Storage\WarehouseRepo;

use App\Http\Requests\Logistics\FormProductRequest;

use App\Exports\ProductsExport;
use App\Exports\ServicesExport;
class ProductsController extends Controller {

	protected $repo;
	protected $stockRepo;
	protected $tableRepo;
	protected $moveRepo;
	protected $warehouseRepo;

	public function __construct(ProductRepo $repo, StockRepo $stockRepo, TableRepo $tableRepo, MoveRepo $moveRepo, WarehouseRepo $warehouseRepo) {
		$this->repo = $repo;
		$this->stockRepo = $stockRepo;
		$this->tableRepo = $tableRepo;
		$this->moveRepo = $moveRepo;
		$this->warehouseRepo = $warehouseRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$tipo = explode('.', request()->route()->getName())[0];
		$warehouses = $this->warehouseRepo->all();
		// $sub_categories = $this->tableRepo->getListGroupType('sub_categories', 'pather', 0);
		if ($tipo == 'services') {
			$sub_categories = $this->tableRepo->getListTypeByGroup('sub_categories', '17');
		} else {
			$sub_categories = $this->tableRepo->getListTypeByGroup('sub_categories', '18');
		}
		$units = $this->tableRepo->getListGroupType('units', 'unit_types');
		$brands = $this->tableRepo->getListType('marcas', 'name', 'name');
		
		return view('partials.create', compact('sub_categories', 'units', 'brands', 'warehouses'));
	}

	public function store(FormProductRequest $request)
	{
		$data = request()->all();
		$this->repo->save($data);
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function show($id)
	{
		$warehouses = $this->warehouseRepo->all();
		$model = $this->repo->findOrFail($id);
		$sub_categories = $this->tableRepo->getListGroupType('sub_categories', 'pather', 0);
		$units = $this->tableRepo->getListGroupType('units', 'unit_types');
		$brands = $this->tableRepo->getListType('marcas', 'name', 'name');
		return view('partials.show', compact('model', 'sub_categories', 'units', 'brands', 'warehouses'));
	}

	public function edit($id)
	{
		$tipo = explode('.', request()->route()->getName())[0];
		$warehouses = $this->warehouseRepo->all();
		$model = $this->repo->findOrFail($id);
		if ($tipo == 'services') {
			$sub_categories = $this->tableRepo->getListTypeByGroup('sub_categories', '17');
		} else {
			$sub_categories = $this->tableRepo->getListTypeByGroup('sub_categories', '18');
		}
		$units = $this->tableRepo->getListGroupType('units', 'unit_types');
		$brands = $this->tableRepo->getListType('marcas', 'name', 'name');
		return view('partials.edit', compact('model', 'sub_categories', 'units', 'brands', 'warehouses'));
	}

	public function update($id, FormProductRequest $request)
	{
		$data = $request->all();
		$data['id']=$id;
		$data = $this->repo->prepareData($data);
		$this->repo->save($data,$id);
		//dd($data);
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function ajaxAutocomplete()
	{
		$term = request()->get('term');
		ini_set('memory_limit','1024M');
		$models = $this->repo->autocomplete($term);
		$result=[];
		foreach ($models as $model) {
			$result[]=[
				'value' => $model->name,
				'id' => $model,
				'label' => $model->intern_code.'  '.$model->name
			];
		}
		return response()->json($result);
	}

	public function ajaxAutocomplete2($warehouse_id = 1)
	{
		$term = request()->get('term');
		ini_set('memory_limit','1024M');
		$models = $this->stockRepo->autocomplete($warehouse_id, $term);
		// dd($models);
		$result=[];
		foreach ($models as $model) {
			$result[]=[
				'value' => $model->product->name,
				'id' => $model,
				'label' => $model->product->intern_code.' | '.$model->product->name
			];
		}
		return response()->json($result);
	}
	public function ajaxGetData($warehouse_id, $product_id)
	{
		$term = request()->get('term');
		$result = $this->repo->ajaxGetData($warehouse_id,$product_id);
		return response()->json($result);
	}
	public function ajaxGetById($id)
	{
		$result = $this->repo->getById($id);
		return response()->json($result);
	}
	public function kardex($id)
	{
		$models = $this->moveRepo->kardex($id);
		// dd($models);
		return view('storage.products.kardex', compact('models'));
	}
	public function excel()
	{
		return \Excel::download(new ProductsExport, 'products.xlsx');
	}
	public function excel2()
	{
		return \Excel::download(new ServicesExport, 'servicios.xlsx');
	}
}
