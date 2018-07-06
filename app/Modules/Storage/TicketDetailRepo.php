<?php
namespace App\Modules\Storage;

use App\Modules\Base\BaseRepo;
use App\Modules\Storage\TicketDetail;

class TicketDetailRepo extends BaseRepo{

	public function getModel(){
		return new TicketDetail;
	}

}