<?php 

namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Storage\Product;
use App\Modules\Storage\ProductRepo;
use App\Modules\Storage\StockRepo;
use App\Modules\Storage\ProductAccessoryRepo;
use App\Modules\Base\AttributeRepo;
use App\Modules\Storage\MoveRepo;
use App\Modules\Storage\Stock;
use App\Modules\Storage\BasicDesign;
use App\Modules\Storage\VProduct;

class ProductRepo extends BaseRepo{

	public function getModel(){
		return new Product;
	}
	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return Product::$filter($search)->with('unit', 'sub_category', 'sub_category.category', 'stocks')->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Product::orderBy('id', 'DESC')->with('unit', 'sub_category', 'sub_category.category', 'stocks')->paginate();
		}
	}
	public function prepareData($data)
	{
		$data['price'] = $data['last_purchase'] * (100 + $data['profit_margin']) / 100;
		if (!isset($data['use_set_price'])) {
			$data['use_set_price'] = false;
		}
		if (isset($data['stocks'])) {
			foreach ($data['stocks'] as $key => $value) {
				//$data['stocks'][$key]['product_id'] = $data['id'];
			}
		}
		//dd($data);
		return $data;
	}
	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		$model = parent::save($data, $id);
		if (isset($data['attributes'])) {
			$attributeRepo= new AttributeRepo;
			$attributeRepo->syncMany($data['attributes'], ['key'=>'attribute_id', 'value'=>$model->id], 'name', ['key'=>'attribute_type', 'value' => $model->getMorphClass()]);
		}
		if (isset($data['stocks'])) {
			$stockRepo= new StockRepo;
			$stockRepo->syncMany($data['stocks'], ['key'=>'product_id', 'value'=>$model->id], 'warehouse_id');
		}
		if (isset($data['accessories'])) {
			$accessoryRepo= new ProductAccessoryRepo;
			$accessoryRepo->syncMany($data['accessories'], ['key'=>'product_id', 'value'=>$model->id], 'accessory_id');
		}
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