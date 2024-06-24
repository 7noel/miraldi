<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Payment;
use App\Modules\Finances\Proof;
use App\Modules\Finances\Bank;

class PaymentRepo extends BaseRepo{

	public function getModel(){
		return new Payment;
	}

	public function save($data, $id=0)
	{
		if (isset($data['proof_id'])) {
			$proof = Proof::find($data['proof_id']);
			if ($proof->proof_type=='output_vouchers') {
				$data['input'] = $data['value'];
				$data['output'] = 0;
			} else {
				$data['output'] = $data['value'];
				$data['input'] = 0;
			}
			$proof->amortization = $proof->amortization + $data['value'];
			// $proof->amortization = $proof->amortization + $data['input'] - $data['output'];
			$proof->save();
		}
		$bank = Bank::find($data['bank_id']);
		$model = parent::save($data, $id);
		$bank->total = $bank->total + $model->input - $model->output;
		$bank->save();

		return $model;
	}
}