<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\Attribute;

class AttributeRepo extends BaseRepo{

	public function getModel(){
		return new Attribute;
	}
}