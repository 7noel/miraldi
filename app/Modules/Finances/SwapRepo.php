<?php 

namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Finances\Swap;

class SwapRepo extends BaseRepo{

	public function getModel(){
		return new Swap;
	}
}