<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Amortization;
use App\Modules\Finances\Payment;
use App\Modules\Finances\Proof;

class AmortizationRepo extends BaseRepo{

	public function getModel(){
		return new Amortization;
	}

	public function saveAll($data, $proof_id)
	{
		$amortization = 0;
		// dd($data);
		foreach ($data['payments'] as $key => $payment) {
			// Graba o Actualiza el pago
			$payment_id = isset($payment['id']) ? $payment['id'] : 0 ;
			$p = Payment::updateOrCreate(['id' => $payment_id], $payment);

			// Graba o actualiza la amortizacion
			$data['amortizations'][$key]['payment_id'] = $p->id;
			$data['amortizations'][$key]['proof_id'] = $proof_id;
			$amortization_id = isset($data['amortizations'][$key]['id']) ? $data['amortizations'][$key]['id'] : 0 ;
			$a = parent::save($data['amortizations'][$key], $amortization_id);
			$amortization += $a->value_proof;
		}

		Proof::where('id', $proof_id)->update(['amortization' => $amortization]);

		return true;
	}
}