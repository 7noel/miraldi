<?php 

namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\TableRepo;
use App\Modules\Storage\Product;
use App\Modules\Storage\StockRepo;
use App\Modules\Storage\ProductAccessoryRepo;
use App\Modules\Storage\MoveRepo;
use App\Modules\Storage\Stock;

class ProductRepo extends BaseRepo{

	public function getModel(){
		return new Product;
	}
	public function index($filter = false, $search = false)
	{
		$tipo = explode('.', request()->route()->getName())[0];
		if($tipo == 'services') {
			$cat = 17;
		} else {
			$cat = 18;
		}
		if ($filter and $search) {
			return Product::$filter($search)->where('category_id', $cat)->with('unit', 'sub_category', 'stocks')->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Product::where('category_id', $cat)->orderBy('id', 'DESC')->with('unit', 'sub_category', 'stocks')->paginate();
		}
	}
	public function prepareData($data)
	{
		if (isset($data['last_purchase']) and isset($data['profit_margin']) and isset($data['admin_expense'])) {
			$data['value'] = $data['last_purchase'] * (100 + $data['profit_margin']) * (100 + $data['admin_expense']) / 10000;
		}
		if (!isset($data['use_set_price'])) {
			$data['use_set_price'] = false;
		}
		if (isset($data['stocks'])) {
			foreach ($data['stocks'] as $key => $value) {
				if (isset($data['stocks'][$key]['stock'])) {
					$data['stocks'][$key]['stock_initial'] = $data['stocks'][$key]['stock'];
				}
				//$data['stocks'][$key]['product_id'] = $data['id'];
			}
		}
		if (isset($data['attributes'])) {
			foreach ($data['attributes'] as $key => $value) {
				$data['attributes'][$key]['type'] = 'attributes';
			}
		}
		return $data;
	}
	public function save($data, $id=0)
	{
		$data['my_company'] = session('my_company')->id;
		$data = $this->prepareData($data);
		// dd($data);
		$model = parent::save($data, $id);
		if (isset($data['attributes'])) {
			$attributeRepo= new TableRepo;
			$attributeRepo->syncMany($data['attributes'], ['key'=>'table_id', 'value'=>$model->id], 'name', ['key'=>'table_type', 'value' => $model->getMorphClass()]);
		}
		
		if (isset($data['stocks'])) {
			$stockRepo= new StockRepo;
			$stockRepo->syncMany($data['stocks'], ['key'=>'product_id', 'value'=>$model->id], 'warehouse_id');
		}
		// if (isset($data['accessories'])) {
		// 	$accessoryRepo= new ProductAccessoryRepo;
		// 	$accessoryRepo->syncMany($data['accessories'], ['key'=>'product_id', 'value'=>$model->id], 'accessory_id');
		// }
		return $model;
	}
	public function autocomplete($term)
	{
		return Product::with('accessories.accessory.sub_category')->where('name','like',"%$term%")->orWhere('intern_code','like',"%$term%")->get();
	}
	public function ajaxGetData($warehouse_id, $product_id)
	{
		$stockRepo = new StockRepo;
		return $stockRepo->ajaxGetData($warehouse_id, $product_id);
	}
	public function getById($id)
	{
		return Product::with('accessories.accessory')->find($id);
	}
}