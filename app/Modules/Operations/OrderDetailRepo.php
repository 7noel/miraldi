<?php
namespace App\Modules\Operations;

use App\Modules\Base\BaseRepo;
use App\Modules\Operations\OrderDetail;

class OrderDetailRepo extends BaseRepo{

	public function getModel(){
		return new OrderDetail;
	}

}