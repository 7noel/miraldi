<?php namespace App\Modules\Operations;

use App\Modules\Base\BaseRepo;
use App\Modules\Operations\Appointment;

class AppointmentRepo extends BaseRepo{

	public function getModel(){
		return new Appointment;
	}

	public function filter($filter)
	{
		$q = Appointment::where('my_company', session('my_company')->id);
		if (trim($filter->placa) != '') {
			return $q->where('placa', $filter->placa)->orderBy('id', 'desc')->get();
			//return Order::where('placa', $filter->placa)->orderBy('sn', 'desc')->get();
		} else {
			$q->where('start_at', '>=', $filter->f1)->where('start_at', '<=', $filter->f2.' 23:59:59');
			if(isset($filter->status_id) && $filter->status_id != '') {
				$q->where('status', $filter->status_id);
			}
			return $q->orderBy('start_at', 'asc')->get();
		}
	}

	public function prepareData($data)
	{
		$data['status'] = 'PEND';
		if (isset($data['approved_at'])) {
			if ($data['approved_at'] == "on") {
				$data['approved_at'] = date('Y-m-d H:i:s');
			}
			$data['status'] = 'APROB';
		} else {
			$data['approved_at'] = null;
		}
		if (isset($data['canceled_at'])) {
			if ($data['canceled_at'] == "on") {
				$data['canceled_at'] = date('Y-m-d H:i:s');
			}
		} else {
			$data['canceled_at'] = null;
		}

		return $data;
	}
	public function cancel($id)
	{
		$model = Appointment::find($id);
		$model->canceled_at = date('Y-m-d H:i:s');
		$model->status = 'ANUL';
		$model->save();
		return $model;
	}
}