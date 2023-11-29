<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\SwapRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Base\CurrencyRepo;
use App\Modules\Finances\Proof;

class SwapsController extends Controller {

	protected $repo;
	protected $companyRepo;
	protected $currencyRepo;

	public function __construct(SwapRepo $repo, CompanyRepo $companyRepo, CurrencyRepo $currencyRepo) {
		$this->repo = $repo;
		$this->companyRepo = $companyRepo;
		$this->currencyRepo = $currencyRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$currencies = $this->currencyRepo->getList('symbol');
		return view('partials.create', compact('currencies'));
	}

	public function store()
	{
		//return back();
		$this->repo->save(request()->all());
		return redirect()->route('finances.swaps.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$currencies = $this->currencyRepo->getList('symbol');
		$model = $this->repo->findOrFail($id);
		$company = $model->company;
		return view('partials.edit', compact('model', 'currencies', 'company'));
	}

	public function update($id)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route('finances.swaps.index');
	}

	public function byProof($proof_id)
	{
		$proof = Proof::find($proof_id);
		if ($proof->swap_id) {

			return $this->edit($proof->swap_id);
		}
		$currencies = $this->currencyRepo->getList('symbol');
		$company = $proof->company;
		return view('partials.create', compact('proof', 'company', 'currencies'));
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('finances.swaps.index');
	}
}
