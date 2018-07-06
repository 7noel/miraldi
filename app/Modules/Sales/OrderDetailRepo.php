<?php
namespace App\Modules\Sales;

use App\Modules\Base\BaseRepo;
use App\Modules\Sales\OrderDetail;

class OrderDetailRepo extends BaseRepo{

	public function getModel(){
		return new OrderDetail;
	}

}