<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\Comment;

class CommentRepo extends BaseRepo{

	public function getModel(){
		return new Comment;
	}
}