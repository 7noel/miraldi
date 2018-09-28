<?php 

namespace App\Modules\Base;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\DocumentControl;

class DocumentControlRepo extends BaseRepo{

	public function getModel(){
		return new DocumentControl;
	}

	static function getNextNumber($document_type_id, $my_company=1, $reference_number='')
	{
		if ($reference_number == '') {
			return DocumentControl::where('company_id', $my_company)->where('document_type_id', $document_type_id)->first();
		} else {
			return DocumentControl::where('company_id', $my_company)->where('document_type_id', $document_type_id)->where('series', 'like', $reference_number[0])->first();
		}
	}
	static function nextNumber($id)
	{
		$d = DocumentControl::find($id);
		$d->number = $d->number + 1;
		$d->save();
		return true;
	}
}