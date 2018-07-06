<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\File;

class FileRepo extends BaseRepo{

	public function getModel(){
		return new File;
	}
}