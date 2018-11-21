<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Amortization;

class AmortizationRepo extends BaseRepo{

	public function getModel(){
		return new Amortization;
	}
}