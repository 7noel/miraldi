<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\DocumentControl;

class DocumentControlRepo extends BaseRepo{

	public function getModel(){
		return new DocumentControl;
	}
}