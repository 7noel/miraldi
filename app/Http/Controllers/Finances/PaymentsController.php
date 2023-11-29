<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\PaymentRepo;
use App\Modules\Finances\ProofRepo;
use App\Modules\Finances\BankRepo;

class PaymentsController extends Controller {

	protected $repo;
	protected $proofRepo;
	protected $bankRepo;

	public function __construct(PaymentRepo $repo, ProofRepo $proofRepo, BankRepo $bankRepo) {
		$this->repo = $repo;
		$this->proofRepo = $proofRepo;
		$this->bankRepo = $bankRepo;
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
		$data = request()->all();
		$this->repo->save($data);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return redirect()->to($data['last_page']);
		}
		return redirect()->route('payments.index');
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
		$data = request()->all();
		$this->repo->save($data, $id);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return redirect()->to($data['last_page']);
		}
		return redirect()->route('payments.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('payments.index');
	}

	public function by_voucher($proof_id)
	{
		$proof = $this->proofRepo->find($proof_id);
		$banks = $this->bankRepo->getList();
		return view('finances.payments.by_voucher', compact('proof', 'banks'));
	}

}
