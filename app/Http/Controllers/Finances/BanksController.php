<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\BankRepo;

class BanksController extends Controller {

	protected $repo;

	public function __construct(BankRepo $repo) {
		$this->repo = $repo;
	}

	public function index()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		return view('partials.create');
	}

	public function store()
	{
		$data = request()->all();
		if (isset($data['initial'])) {
			$data['total'] = $data['initial'];
		}
		$this->repo->save($data);
		return redirect()->route('banks.index');
	}

	public function show($id)
	{
		$model = $this->repo->findOrFail($id);
		return view('finances.banks.detail', compact('model'));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		return view('partials.edit', compact('model'));
	}

	public function update($id)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route('banks.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('banks.index');
	}

}
