<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\SunatTable;

class SunatRepo extends BaseRepo{

	public function getModel(){
		return new SunatTable;
	}
	public function getList2($catalog, $table)
	{
		return [""=>'Seleccionar'] + SunatTable::where('catalog', $catalog)->where('table', $table)->where('is_activated', true)->pluck('description', 'id')->toArray();
	}
}