<?php namespace App\Modules\Logistics;

use App\Modules\Base\BaseRepo;
use App\Modules\Logistics\Purchase;
use App\Modules\Logistics\PurchaseDetailRepo;
use App\Modules\Base\ExpenseRepo;
use App\Modules\Storage\MoveRepo;
use App\Modules\Storage\Stock;

class PurchaseRepo extends BaseRepo{

	public function getModel(){
		return new Purchase;
	}
	public function index($filter = false, $search = false)
	{
		if ($filter and $search) {
			return Purchase::$filter($search)->with('company', 'document_type', 'payment_condition', 'currency')->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Purchase::orderBy('id', 'DESC')->with('company', 'document_type', 'payment_condition', 'currency')->paginate();
		}
	}

	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);

		$model = parent::save($data, $id);
		// Registra Movimientos
		if (isset($data['details'])) {
			$detailRepo = new PurchaseDetailRepo;
			$toDelete = $detailRepo->syncMany($data['details'], ['key' => 'purchase_id', 'value' => $model->id], 'product_id');

			if (1==1) {
				$mov = new MoveRepo;
				$mov->destroy($toDelete);
				$mov->saveAll($model, 1);
			}
		}
		$this->saveExpenses($data, $model);
		return $model;
	}

	public function prepareData($data)
	{
		if ($data['document_type_id'] == 3) {
			$data['mov'] = 0;
		} else {
			$data['mov'] = 1;
		}

		if ($data['is_import']) {
			$data['type_op'] = '18'; //2152
		} else {
			$data['type_op'] = '02'; //2136
		}
		
		
		if (!isset($data['warehouse_id']) or $data['warehouse_id'] == '' or $data['warehouse_id'] == '0') {
			$data['warehouse_id'] = 1;
		}
		if (isset($data['expenses']) and $data['is_import'] != 1) {
			foreach ($data['expenses'] as $key => $exp) {
				$data['expenses'][$key]['is_deleted'] = 1;
			}
		}
		$gross_value = 0;
		$expenses = 0;
		$expenseCif = 0;
		if (isset($data['expenses'])) {
			foreach ($data['expenses'] as $key => $expense) {
				if ($key < 3) {
					$expenseCif += $expense['value'];
				}
				$expenses += $expense['value'];
				//$data['expenses'][$key]['currency_id'] = 2;
			}
		}
		//dd($data['expenses']);
		if (isset($data['details'])) {
			foreach ($data['details'] as $key => $detail) {
				if (!isset($detail['is_deleted'])) {
					if (!isset($detail['discount'])) {
						$detail['discount'] = 0;
					}
					$data['details'][$key]['total'] = round($detail['value']*$detail['quantity']*(100-$detail['discount']))/100;
					$gross_value += $data['details'][$key]['total'];
				}
			}
		}
		//cacular factor
		$factor = 1;
		if ($gross_value>0) {
			$factor = ($gross_value + $expenses) / $gross_value;
		}
		if (isset($data['details'])) {
			foreach ($data['details'] as $key => $detail) {
				if (!isset($detail['is_deleted'])) {
					$data['cost'] = round(($detail['value']*$factor), 2);
				}
			}
		}
		$data['gross_value'] = $gross_value;
		$data['subtotal'] = $gross_value + $expenseCif;
		$data['total'] = round($data['subtotal'] * (100 + config('options.tax.igv')) / 100, 2);
		$data['tax'] = $data['total'] - $data['subtotal'];

		// Obteniendo el stock_id
		if (isset($data['details'])) {
			foreach ($data['details'] as $key => $detail) {
				if (!isset($detail['stock_id']) and 1 == 1) {
					if (!isset($detail['warehouse_id'])) {
						$detail['warehouse_id'] = $data['warehouse_id'];
					}
					$s = Stock::firstOrCreate(['product_id' => $detail['product_id'], 'warehouse_id' => $detail['warehouse_id']]);
					$data['details'][$key]['stock_id'] = $s->id;
				}
			}
		}
		return $data;
	}

	/**
	 * guarda gastos de exportacion
	 * @param  [array] $expenses     [Data de los gastos]
	 * @param  [int] $model_id     [id de la importación]
	 * @param  [string] $expense_type [Modelo de la importación]
	 * @return [boolean]               [Retorna true al terminar de guardar]
	 */
	protected function saveExpenses($data, $model)
	{
		if (isset($data['expenses'])) {
			$expenseRepo = new ExpenseRepo;
			$expenseRepo->syncMany($data['expenses'], ['key' => 'expense_id', 'value' => $model->id], 'name', ['key'=>'expense_type', 'value' => $model->getMorphClass()]);
			return true;
		} else {
			return false;
		}
	}
}