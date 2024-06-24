<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Swap;
use App\Modules\Finances\ProofRepo;

class SwapRepo extends BaseRepo{

	public function getModel(){
		return new Swap;
	}
	public function prepareData($data)
	{
		// dd($data);
		if (isset($data['letters'])) {
			foreach ($data['letters'] as $key => $letter) {
				$data['letters'][$key]['document_type_id'] = '7';
				$data['letters'][$key]['payment_condition_id'] = '2';
				$data['letters'][$key]['currency_id'] = $data['currency_id'];
				$data['letters'][$key]['company_id'] = $data['company_id'];
				$data['letters'][$key]['total'] = $data['letters'][$key]['subtotal'] + $data['letters'][$key]['interest'];
			}
		}
		return $data;
	}
	public function save($data, $id=0)
	{
		// dd($data);
		$data = $this->prepareData($data);
		$model = parent::save($data, $id);

		$detailRepo= new ProofRepo;
		if (isset($data['proofs'])) {
			$detailRepo->saveMany2($data['proofs'], ['key' => 'swap_id', 'value' => $model->id]);
		}
		if (isset($data['letters'])) {
			$detailRepo->saveMany2($data['letters'], ['key' => 'swap_letter_id', 'value' => $model->id]);
		}
		$model->amount_proofs = $model->proofs->sum('total');
		$model->amount_letters = $model->letters->sum('total');
		$model->save();

		return $model;
	}
}