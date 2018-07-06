<?php 

namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Storage\ProductAccessory;

class ProductAccessoryRepo extends BaseRepo{

	public function getModel(){
		return new ProductAccessory;
	}
}