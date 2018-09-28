<?php namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\ProofDetail;

class ProofDetailRepo extends BaseRepo{

	public function getModel(){
		return new ProofDetail;
	}
}