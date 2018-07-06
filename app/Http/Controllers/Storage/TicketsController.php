<?php namespace App\Http\Controllers\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Storage\TicketRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Storage\WarehouseRepo;
use App\Modules\Base\SunatRepo;

class TicketsController extends Controller {

	protected $repo;
	protected $companyRepo;
	protected $warehouseRepo;
	protected $sunatRepo;

	public function __construct(TicketRepo $repo, CompanyRepo $companyRepo, WarehouseRepo $warehouseRepo, SunatRepo $sunatRepo) {
		$this->repo = $repo;
		$this->companyRepo = $companyRepo;
		$this->warehouseRepo = $warehouseRepo;
		$this->sunatRepo = $sunatRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', \Request::get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$warehouses = $this->warehouseRepo->getList();
		$types = $this->sunatRepo->getList2('SUN', 12);
		return view('partials.create', compact('warehouses', 'types'));
	}

	public function store()
	{
		$this->repo->save(\Request::all());
		return \Redirect::route('tickets.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$warehouses = $this->warehouseRepo->getList();
		$types = $this->sunatRepo->getList2('SUN', 12);
		$model = $this->repo->findOrFail($id);
		return view('partials.edit', compact('model', 'warehouses', 'types'));
	}

	public function update($id)
	{
		$this->repo->save(\Request::all(), $id);
		return \Redirect::route('tickets.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route('tickets.index');
	}
}
