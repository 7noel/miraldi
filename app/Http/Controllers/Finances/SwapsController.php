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
		$models = $this->repo->index('name', \Request::get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		return view('partials.create');
	}

	public function store()
	{
		$this->repo->save(\Request::all());
		return \Redirect::route('swaps.index');
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

	public function update($id)
	{
		$this->repo->save(\Request::all(), $id);
		return \Redirect::route('swaps.index');
	}

	public function byProof($proof_id)
	{
		$proof = Proof::find($proof_id);
		if ($proof->swap_id) {

			return $this->edit($proof->swap_id);
		}
		$my_companies = $this->companyRepo->getListMyCompany();
		$currencies = $this->currencyRepo->getList('symbol');
		$company = $proof->company;
		return view('partials.create', compact('proof', 'company', 'my_companies', 'currencies'));
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route('swaps.index');
	}
}
