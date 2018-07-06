<?php
namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Storage\Ticket;
use App\Modules\Storage\TicketDetailRepo;

class TicketRepo extends BaseRepo{

	public function getModel(){
		return new Ticket;
	}
	public function findOrFail($id){
		return Ticket::with('details.stock.product')->findOrFail($id);
	}
	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		$model = parent::save($data, $id);

		if (isset($data['details'])) {
			$detailRepo= new TicketDetailRepo;
			$toDelete = $detailRepo->syncMany($data['details'], ['key' => 'ticket_id', 'value' => $model->id], 'stock_id');

			if (1 == 1) {
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
		// $data['mov'] = 0;
		// $data['type_op'] = '01'; //2135
		// if (!isset($data['warehouse_id']) or $data['warehouse_id'] == '' or $data['warehouse_id'] == '0') {
		// 	$data['warehouse_id'] = 1;
		// }
		
		// //Calculando totales
		// $gross_value = 0;
		// $discount = 0;
		// if (isset($data['details'])) {
		// 	foreach ($data['details'] as $key => $detail) {
		// 		$data['details'][$key]['total'] = round($detail['price']*$detail['quantity']*(100-$detail['discount']))/100;
		// 		if (!isset($detail['is_deleted'])) {
		// 			$gross_value += round($detail['price']*$detail['quantity'], 2);
		// 			$discount += round($detail['price']*$detail['quantity']*$detail['discount'])/100;
		// 		}
		// 		$data['gross_value'] = $gross_value;
		// 		$data['discount'] = $discount;
		// 		$data['subtotal'] = $gross_value - $discount;
		// 		$data['total'] = round($data['subtotal'] * (100 + config('options.tax.igv')) / 100, 2);
		// 		$data['tax'] = $data['total'] - $data['subtotal'];

		// 		// Obteniendo el stock_id
		// 		if (!isset($detail['stock_id']) and isset($data['sent_at']) ) {
		// 			if (!isset($detail['warehouse_id'])) {
		// 				$detail['warehouse_id'] = $data['warehouse_id'];
		// 			}
		// 			$s = Stock::firstOrCreate(['product_id' => $detail['product_id'], 'warehouse_id' => $detail['warehouse_id']]);
		// 			$data['details'][$key]['stock_id'] = $s->id;
		// 		}
		// 	}
		// }

		return $data;
	}
}