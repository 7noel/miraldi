<?php
namespace App\Modules\Sales;

use App\Modules\Base\BaseRepo;
use App\Modules\Sales\Order;
use App\Modules\Sales\OrderDetailRepo;

class OrderRepo extends BaseRepo{

	public function getModel(){
		return new Order;
	}
	public function findOrFail($id){
		return Order::with('details.product.brand', 'details.product.accessories.accessory.sub_category')->findOrFail($id);
	}
	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		$model = parent::save($data, $id);

		if (isset($data['details'])) {
			$detailRepo= new OrderDetailRepo;
			$toDelete = $detailRepo->syncMany($data['details'], ['key' => 'order_id', 'value' => $model->id], 'product_id');

			if (isset($data['sent_at'])) {
				$mov = new MoveRepo;
				$mov->destroy($toDelete);
				$mov->saveAll($model, 0);
			}
		}
		return $model;
	}
	public function prepareData($data)
	{
		$data['document_type_id'] = 6;
		$data['mov'] = 0;
		$data['type_op'] = '01'; //2135
		if (!isset($data['warehouse_id']) or $data['warehouse_id'] == '' or $data['warehouse_id'] == '0') {
			$data['warehouse_id'] = 1;
		}
		
		//Calculando totales
		$gross_value = 0;
		$discount = 0;
		$subtotal = 0;
		$total = 0;
		if (isset($data['details'])) {
			foreach ($data['details'] as $key => $detail) {
				$data['details'][$key]['total'] = round($detail['value']*$detail['quantity']*(100-$detail['discount']))/100;
				if (!isset($detail['is_deleted'])) {
					if ($data['with_tax']) {
						$total += round($detail['price']*$detail['quantity']*(100-$detail['discount']))/100; //total = q*p*(100-d)/100 + total;
						$subtotal = $total * 100 / (100 + config('options.tax.igv'));
						$gross_value += $detail['price']*100/(100 + config('options.tax.igv'))*$detail['quantity'];
						$discount += $detail['price']*100/(100 + config('options.tax.igv'))*$detail['quantity']*$detail['discount']/100;
						// discount = (q*v*d)/100 + discount;
					} else {
						$gross_value += round($detail['value']*$detail['quantity'], 2);
						$discount += round($detail['value']*$detail['quantity']*$detail['discount'])/100;
						$subtotal = $gross_value - $discount;
						$total = round($data['subtotal'] * (100 + config('options.tax.igv')) / 100, 2);
					}
					
				}

				// Obteniendo el stock_id
				if (!isset($detail['stock_id']) and isset($data['sent_at']) ) {
					if (!isset($detail['warehouse_id'])) {
						$detail['warehouse_id'] = $data['warehouse_id'];
					}
					$s = Stock::firstOrCreate(['product_id' => $detail['product_id'], 'warehouse_id' => $detail['warehouse_id']]);
					$data['details'][$key]['stock_id'] = $s->id;
				}
			}
			$data['gross_value'] = round($gross_value, 2);
			// $data['discount'] = round($discount, 2);
			$data['subtotal'] = round($subtotal, 2);
			$data['discount'] = $data['gross_value'] - $data['subtotal'];
			$data['total'] = round($data['subtotal'] * (100 + config('options.tax.igv')) / 100, 2);
			$data['tax'] = $data['total'] - $data['subtotal'];
		}

		// Actualizando Status
		$data['status'] = config('options.order_status.0');
		if (isset($data['checked_at'])) {
			if ($data['checked_at'] == "on") {
				$data['checked_at'] = date('Y-m-d H:i:s');
			}
			$data['status'] = config('options.order_status.1');
		} else {
			$data['checked_at'] = null;
		}
		if (isset($data['approved_at'])) {
			if ($data['approved_at'] == "on") {
				$data['approved_at'] = date('Y-m-d H:i:s');
			}
			$data['status'] = config('options.order_status.2');
		} else {
			$data['approved_at'] = null;
		}
		if (isset($data['invoiced_at'])) {
			if ($data['invoiced_at'] == "on") {
				$data['invoiced_at'] = date('Y-m-d H:i:s');
			}
			$data['status'] = config('options.order_status.3');
		} else {
			$data['invoiced_at'] = null;
		}
		if (isset($data['sent_at'])) {
			if ($data['sent_at'] == "on") {
				$data['sent_at'] = date('Y-m-d H:i:s');
			}
			$data['status'] = config('options.order_status.4');
		} else {
			$data['sent_at'] = null;
		}
		if (isset($data['canceled_at'])) {
			if ($data['canceled_at'] == "on") {
				$data['canceled_at'] = date('Y-m-d H:i:s');
			}
			$data['status'] = config('options.order_status.5');
		} else {
			$data['canceled_at'] = null;
		}
		return $data;
	}
}