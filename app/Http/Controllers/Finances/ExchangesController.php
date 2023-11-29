<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Base\Exchange;
use App\Modules\Base\IdType;
use App\Modules\Finances\ExchangeRepo;

use App\Http\Requests\Finances\FormExchangeRequest;

class ExchangesController extends Controller {

	protected $repo;
	protected $currencyRepo;

	public function __construct(ExchangeRepo $repo) {
		$this->repo = $repo;
	}
	
	public function index()
	{
		$models = $this->repo->index('fecha', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		return view('partials.create');
	}

	public function store(FormExchangeRequest $request)
	 
	{
		$this->repo->save(request()->all());
		return redirect()->route('exchanges.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		return view('partials.edit', compact('model'));
	}

	public function update($id, FormExchangeRequest $request)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route('exchanges.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('exchanges.index');
	}

}
