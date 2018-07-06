<?php 

namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Storage\Stock;

class StockRepo extends BaseRepo{

	public function getModel(){
		return new Stock;
	}
	public function savefull($data, $product_id)
	{
		$old = Stock::where('product_id',$product_id)->lists('warehouse_id');
		foreach ($data as $key => $value) {
			$new[] = intval($value['warehouse_id']);
		}
		if (!isset($old)) { $old=[]; }
		$toDelete = array_diff($old, $new);
		$toSave = array_diff($new, $old);
		if (!empty($toDelete)) {
			//Stock::where('product_id', 16)->whereIn('warehouse_id',$toDelete)->delete();
			Stock::where('product_id', $product_id)->where('stock', 0)->whereIn('warehouse_id',$toDelete)->delete();
		}
		foreach ($data as $key => $value) {
			if (in_array($value['warehouse_id'], $toSave)) {
				$model= new Stock;
				$model->fill($value);
				$model->save();
			}
		}
	}
	public function autocomplete($warehouse_id, $term)
	{
		return Stock::with('product.unit')->where('warehouse_id', '=', $warehouse_id)
			->whereHas('product', function ($q) use ($term){
				$q->where('name','like',"%$term%")
				->orWhere('intern_code','like',"%$term%");
			})->get();
	}
	public function ajaxGetData($warehouse_id, $product_id)
	{
		return Stock::where('warehouse_id', $warehouse_id)->where('product_id',$product_id)->with('product','product.unit')->first();
	}

}