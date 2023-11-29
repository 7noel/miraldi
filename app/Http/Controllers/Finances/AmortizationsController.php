<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\AmortizationRepo;
use App\Modules\Finances\ProofRepo;
use App\Modules\Finances\BankRepo;
use App\Modules\Base\CurrencyRepo;

class AmortizationsController extends Controller {

	protected $repo;
	protected $proofRepo;
	protected $bankRepo;
	protected $currencyRepo;

	public function __construct(AmortizationRepo $repo, ProofRepo $proofRepo, BankRepo $bankRepo, CurrencyRepo $currencyRepo) {
		$this->repo = $repo;
		$this->proofRepo = $proofRepo;
		$this->bankRepo = $bankRepo;
		$this->currencyRepo = $currencyRepo;
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
		$this->repo->save(request()->all());
		return redirect()->route('payment_conditions.index');
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
		$this->repo->saveAll(request()->all(), $id);
		return redirect()->route('issuance_vouchers.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('issuance_vouchers.index');
	}

	public function byProof($proof_id)
	{
		$model = $this->proofRepo->findWithAmortizations($proof_id);
		$banks = $this->bankRepo->getList('label');
		$currencies = $this->currencyRepo->getList('symbol');
		return view('finances.amortizations.by_proof', compact('model', 'banks', 'currencies'));
		dd($banks);
	}
}
