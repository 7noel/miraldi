<?php namespace App\Http\Controllers\Operations;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Operations\AppointmentRepo;

class AppointmentController extends Controller {

	protected $repo;

	public function __construct(AppointmentRepo $repo) {
		$this->repo = $repo;
	}

	public function index()
	{
		$filter = (object) request()->all();
		if( !((array) $filter) ) {
			$filter->placa = '';
			$filter->f1 = date('Y-m-d');
			$filter->f2 = date("Y-m-d", strtotime(date('Y-m-d')."+ 2 weeks"));
		}
		$models = $this->repo->filter($filter);
		return view('partials.filter',compact('models', 'filter'));
	}

	public function create()
	{
		return view('partials.create');
	}

	public function store()
	{
		$this->repo->save(request()->all());
		return redirect()->route('appointments.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		// dd($model->start_at);
		return view('partials.edit', compact('model'));
	}

	public function update($id)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route('appointments.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('operations.appointments.index');
	}

}