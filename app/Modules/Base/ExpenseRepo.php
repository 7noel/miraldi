<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\Expense;

class ExpenseRepo extends BaseRepo{

	public function getModel(){
		return new Expense;
	}
}