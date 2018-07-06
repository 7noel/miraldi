<?php 

namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Storage\Move;
use App\Modules\Storage\StockRepo;
use App\Modules\Storage\Unit;

class MoveRepo extends BaseRepo{

	public function getModel(){
		return new Move;
	}

	public function prepareData($data)
	{
		$unit_model = Unit::find($data['unit_id']);
		if ($unit_model->value == 1) {
			$data['unit_id'] = $unit_model->id;
		} else {
			$unit_base = Unit::where('unit_type_id', $unit_model->unit_type_id)->where('value', 1)->first();
			$data['unit_id'] = $unit_base->id;
		}
		$data['input'] = $data['input'] * $unit_model->value;
		$data['output'] = $data['output'] * $unit_model->value;
		$data['value'] = $data['value'] / $unit_model->value;
		return $data;
	}

	/**
	 * Guarda los movimientos de los productos.
	 * @param  array  $data Array con los datos para agregar un movimientos.
	 * @param  integer $id   Es el id de un movimiento, se usara para modificar un movimiento.
	 * @return Obj        Retorna un Obj que es modelo del movimiento despues de actualizar el stock.
	 */
	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		$stockRepo = new StockRepo;
		$st_model = $stockRepo->find($data['stock_id']);
		// saber si ya tiene un movimiento
		$model_current = $this->model->where('move_type', $data['move_type'])->where('move_id', $data['move_id'])->first();
		if ($model_current) {
			$id = $model_current->id;
		}
		/**
		 * IF: Modificar un movimiento. FOREACH: itera con el movimiento a modificar y con los posteriores.
		 * ELSE: Agregar un movimiento
		 */
		$last_stock = 0;
		$last_avarage = 0;
		$model = '';
		if ($id > 0) {
			// $moves_before = $this->model->where('id', '>=', $id)->where('stock_id', $data['stock_id'])->orderBy('date', 'asc')->orderBy('id', 'asc')->get();
			$moves_before = $this->model->where('id', '>=', $id)->where('stock_id', $data['stock_id'])->orderBy('id', 'asc')->get();
			foreach ($moves_before as $key => $move_before) {
				if ($move_before->id == $id) {
					$last_stock = $move_before->stock + $move_before->output - $move_before->input;
					$last_avarage = $move_before->avarage_value_before;
					$q = $data['input'] - $data['output'];
					$v = ($data['change_value']) ? $data['value'] : $last_avarage;
				} else {
					unset($data);
					$q = $move_before->input - $move_before->output;
					$v = ($move_before->change_value) ? $move_before->value : $last_avarage;
				}
				$data['id'] = $move_before->id;
				$data = array_merge($data, $this->calcAvarage($last_stock, $last_avarage, $q, $v));
				$last_stock = $data['stock'];
				$last_avarage =	$data['avarage_value_after'];
				$model = parent::save($data, $move_before->id);
			}
		} else {
			// $move_before = $this->model->where('stock_id', $data['stock_id'])->orderBy('date', 'desc')->orderBy('id', 'desc')->first();
			$move_before = $this->model->where('stock_id', $data['stock_id'])->orderBy('id', 'desc')->first();
			if ($move_before) {
				$last_stock = $move_before->stock;
				$last_avarage = $move_before->avarage_value_after;
			} else {
				$last_stock = 0;
				$last_avarage = $data['value'];
			}
			
			$q = $data['input'] - $data['output'];
			$v = ($data['change_value']) ? $data['value'] : $last_avarage;
			$data = array_merge($data, $this->calcAvarage($last_stock, $last_avarage, $q, $v));
			$last_stock = $data['stock'];
			$last_avarage =	$data['avarage_value_after'];
			$model = parent::save($data, 0);
		}
		$st_model->stock = $last_stock;
		$st_model->avarage_value = $last_avarage;
		$st_model->save();
		return $model;
	}

	public function destroy($toDelete)
	{
		if (is_null($toDelete)) {
			return false;
		}
		if (count($toDelete) > 0) {
			return false;
		}
		foreach ($toDelete as $key2 => $id) {
			$last_stock = 0;
			$last_avarage = 0;
			$model = '';
			//encuentra los movimientos desde este id en adelante correspondiente a este stock_id
			$move_current = $this->model->find($id);
			$moves_before = $this->model->where('id', '>=', $id)->where('stock_id', $move_current->stock_id)->orderBy('id', 'asc')->get();
			foreach ($moves_before as $key => $move_before) {
				if ($move_before->id == $id) {
					$last_stock = $move_before->stock + $move_before->output - $move_before->input;
					$last_avarage = $move_before->avarage_value_before;
					$q = 0;
					$v = $last_avarage;
				} else {
					unset($data);
					$q = $move_before->input - $move_before->output;
					$v = ($move_before->change_value) ? $move_before->value : $last_avarage;
				}
				$data['id'] = $move_before->id;
				$data = $this->calcAvarage($last_stock, $last_avarage, $q, $v);
				$last_stock = $data['stock'];
				$last_avarage =	$data['avarage_value_after'];
				$model = $move_before->delete();
			}
			$st_model->stock = $last_stock;
			$st_model->avarage_value = $last_avarage;
			$st_model->save();
		}
		return true;
	}

	/**
	 * Calcula el valor promedio.
	 * @param  decimal $q0 Stock antes del movimiento.
	 * @param  decimal $v0 Valor promedio antes del movimiento.
	 * @param  decimal $q  Cantidad de unidades en el movimiento actual.
	 * @param  decimal $v  Valor del producto en el movimiento actual.
	 * @return array     Devuelve el stock, Valor Promedio antes del movimiento y Valor Promedio despues del movimiento.
	 */
	protected function calcAvarage($q0,$v0,$q,$v)
	{
		$arr['stock'] = $q0 + $q;
		$arr['avarage_value_before'] = $v0;
		$arr['avarage_value_after'] = ($q0*$v0 + $q*$v) / ($q0 + $q);
		//$arr['avarage_value_after'] = round(($q0*$v0 + $q*$v) / ($q0 + $q), 2);
		return $arr;
	}

	public function getMove($move_type, $detail_id)
	{
		return $this->model->where('move_type', $move_type)->where('move_id', $detail_id)->first();
	}

	public function saveAll($model, $change_value)
	{
		\DB::transaction(function () use ($model, $change_value){
			foreach ($model->details as $key => $detail) {
				// prepara la trama para usar el metodo save de MoveRepo
				// $d['date'] = $model->date;
				$d['document'] = $model->document_type->name;
				$d['code_document'] = $model->document_type->code;
				$d['change_value'] = $change_value;
				$d['type_op'] = $model->type_op;
				$d['number'] = $model->id;
				if (isset($model->number)) {
					$d['number'] = $model->number;
				}
				if ($model->mov) {
					$d['input'] = $detail->quantity;
					$d['output'] = 0;
				} else {
					$d['input'] = 0;
					$d['output'] = $detail->quantity;
				}
				$d['stock_id'] = $detail->stock_id;
				$d['unit_id'] = $detail->unit_id;
				if (isset($detail->cost)) {
					$d['value'] = $detail->value;
				} elseif (isset($detail->value)) {
					$d['value'] = $detail->value;
				} else {
					$d['value'] = 0;
				}
				$d['move_type'] = $detail->getMorphClass();
				$d['move_id'] = $detail->id;
				$this->save($d);
			}
		});
	}

	public function kardex($stock_id)
	{
		return $this->model->where('stock_id', $stock_id)->with('move.parent.document_type')->get();
	}
}