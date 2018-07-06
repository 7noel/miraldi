<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Base\DocumentControlRepo;
use App\Modules\Base\DocumentTypeRepo;
use App\Modules\Finances\CompanyRepo;

class DocumentControlsController extends Controller {

	protected $repo;
	protected $documentTypeRepo;
	protected $companyRepo;

	public function __construct(DocumentControlRepo $repo, DocumentTypeRepo $documentTypeRepo, CompanyRepo $companyRepo) {
		$this->repo = $repo;
		$this->documentTypeRepo = $documentTypeRepo;
		$this->companyRepo = $companyRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', \Request::get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$myCompanies = $this->companyRepo->getListMyCompany();
		$documents = $this->documentTypeRepo->getList();
		return view('partials.create', compact('myCompanies', 'documents'));
	}

	public function store()
	{
		$this->repo->save(\Request::all());
		return \Redirect::route('document_controls.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$myCompanies = $this->companyRepo->getListMyCompany();
		$documents = $this->documentTypeRepo->getList();
		return view('partials.edit', compact('model', 'myCompanies', 'documents'));
	}

	public function update($id)
	{
		$this->repo->save(\Request::all(), $id);
		return \Redirect::route('document_controls.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route('document_controls.index');
	}


}
