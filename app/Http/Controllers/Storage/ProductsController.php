<?php namespace App\Http\Controllers\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Storage\UnitRepo;
use App\Modules\Storage\SizeRepo;
use App\Modules\Storage\ColorRepo;
use App\Modules\Storage\MaterialRepo;
use App\Modules\Base\UnitTypeRepo;
use App\Modules\Storage\CategoryRepo;
use App\Modules\Storage\SubCategoryRepo;
use App\Modules\Storage\ProductRepo;
use App\Modules\Storage\StockRepo;
use App\Modules\Storage\Product;
use App\Modules\Base\CurrencyRepo;
use App\Modules\Base\SunatRepo;
use App\Modules\Logistics\BrandRepo;
use App\Modules\Storage\MoveRepo;

use App\Http\Requests\Logistics\FormProductRequest;

class ProductsController extends Controller {

	protected $repo;
	protected $stockRepo;
	protected $categoryRepo;
	protected $subCategoryRepo;
	protected $unitRepo;
	protected $unitTypeRepo;
	protected $currencyRepo;
	protected $sunatRepo;
	protected $brandRepo;
	protected $moveRepo;

	public function __construct(ProductRepo $repo, StockRepo $stockRepo,SubCategoryRepo $subCategoryRepo, CategoryRepo $categoryRepo, UnitRepo $unitRepo, UnitTypeRepo $unitTypeRepo, CurrencyRepo $currencyRepo, SunatRepo $sunatRepo, BrandRepo $brandRepo, MoveRepo $moveRepo) {
		$this->repo = $repo;
		$this->stockRepo = $stockRepo;
		$this->categoryRepo = $categoryRepo;
		$this->subCategoryRepo = $subCategoryRepo;
		$this->unitRepo = $unitRepo;
		$this->unitTypeRepo = $unitTypeRepo;
		$this->currencyRepo = $currencyRepo;
		$this->sunatRepo = $sunatRepo;
		$this->brandRepo = $brandRepo;
		$this->moveRepo = $moveRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', \Request::get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$sub_categories = $this->subCategoryRepo->getListGroup('category');
		$units = $this->unitRepo->getListGroup('unit_type');
		$currencies = $this->currencyRepo->getList('symbol');
		$brands = $this->brandRepo->getList();
		$countries = $this->sunatRepo->getList2('FE', 4);
		
		return view('partials.create', compact('sub_categories', 'units', 'currencies', 'brands', 'countries'));
	}

	public function store(FormProductRequest $request)
	{
		$this->repo->save(\Request::all());
		return \Redirect::route('products.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$currencies = $this->currencyRepo->getList('symbol');
		$sub_categories = $this->subCategoryRepo->getListGroup('category');
		$units = $this->unitRepo->getListGroup('unit_type');
		$brands = $this->brandRepo->getList();
		$countries = $this->sunatRepo->getList2('FE', 4);
		return view('partials.edit', compact('model', 'sub_categories', 'units', 'currencies', 'brands', 'countries'));
	}

	public function update($id, FormProductRequest $request)
	{
		$data = $request->all();
		$data['id']=$id;
		$data = $this->repo->prepareData($data);
		$this->repo->save($data,$id);
		//dd($data);
		return \Redirect::route('products.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route('products.index');
	}

	public function ajaxAutocomplete()
	{
		$term = \Input::get('term');
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
		return \Response::json($result);
	}

	public function ajaxAutocomplete2($warehouse_id = 1)
	{
		$term = \Input::get('term');
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
		return \Response::json($result);
	}
	public function ajaxGetData($warehouse_id, $product_id)
	{
		$term = \Input::get('term');
		$result = $this->repo->ajaxGetData($warehouse_id,$product_id);
		return \Response::json($result);
	}
	public function ajaxGetById($id)
	{
		$result = $this->repo->getById($id);
		return \Response::json($result);
	}
	public function kardex($id)
	{
		$models = $this->moveRepo->kardex($id);
		// dd($models);
		return view('storage.products.kardex', compact('models'));
	}
}
