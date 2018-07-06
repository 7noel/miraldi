<?php namespace App\Http\Controllers\Security;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuditController extends Controller {


	public function getAudit($model, $id)
	{
		$class = new $model;
		$object = $class->findOrFail($id);
		$audits = $object->audits()->with('user')->get();
		return view('guard.audits.audit_model', compact('audits'));
	}


}
