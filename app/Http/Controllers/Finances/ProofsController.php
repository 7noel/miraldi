<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\ProofRepo;
use App\Modules\Base\DocumentTypeRepo;
use App\Modules\Base\CurrencyRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Finances\PaymentConditionRepo;
use App\Modules\Storage\WarehouseRepo;
use App\Modules\HumanResources\EmployeeRepo;
use App\Modules\Sales\OrderRepo;

class ProofsController extends Controller {

	protected $repo;
	protected $documentTypeRepo;
	protected $currencyRepo;
	protected $companyRepo;
	protected $paymentConditionRepo;
	protected $warehouseRepo;
	protected $employeeRepo;
	protected $orderRepo;

	protected $proof_type;
	protected $doc;

	public function __construct(EmployeeRepo $employeeRepo, ProofRepo $repo, DocumentTypeRepo $documentTypeRepo, CurrencyRepo $currencyRepo, CompanyRepo $companyRepo, PaymentConditionRepo $paymentConditionRepo, WarehouseRepo $warehouseRepo, OrderRepo $orderRepo) {
		$this->repo = $repo;
		$this->documentTypeRepo = $documentTypeRepo;
		$this->currencyRepo = $currencyRepo;
		$this->companyRepo = $companyRepo;
		$this->paymentConditionRepo = $paymentConditionRepo;
		$this->warehouseRepo = $warehouseRepo;
		$this->employeeRepo = $employeeRepo;
		$this->orderRepo = $orderRepo;

		$this->getType();
	}

	public function issuanceVouchers()
	{
		$models = $this->repo->issuanceVouchers('number', \Request::get('name'));
		return view('finances.proofs.issuance_vouchers',compact('models'));
	}

	public function create()
	{
		// dd(\Request::route()->action['as']);
		$my_companies = $this->companyRepo->getListMyCompany();
		$proof_type = $this->proof_type;
		$sunat_transaction = 1;
		$igv_code = 1;
		$document_types = $this->documentTypeRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->employeeRepo->getListSellers();
		return view('partials.create', compact('proof_type', 'document_types', 'currencies', 'payment_conditions', 'sellers', 'my_companies', 'sunat_transaction', 'igv_code'));
	}


	public function byOrder($order_id)
	{
		$model = $this->orderRepo->findOrFail($order_id);
		$my_companies = $this->companyRepo->getListMyCompany();

		$sunat_transaction = 1;
		$igv_code = 1;
		$proof_type = $this->proof_type;
		$document_types = $this->documentTypeRepo->getList2();
		$currencies = $this->currencyRepo->getList('symbol');
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->employeeRepo->getListSellers();
		return view('partials.create', compact('model', 'order_id', 'document_types', 'currencies', 'payment_conditions', 'sellers', 'warehouses','items', 'proof_type', 'my_companies', 'sunat_transaction', 'igv_code'));
	}

	public function index()
	{
		$models = $this->repo->index('sn', \Request::get('name'), $this->proof_type);
		return view('partials.index',compact('models'));
	}

	public function store()
	{
		//dd(\Request::all());
		$this->repo->save(\Request::all());
		return redirect()->route($this->doc.'.index');
	}

	public function show($id)
	{
		$model = $this->repo->findOrFail($id);
		$p='p';
		dd(json_decode($model->response_sunat));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$my_companies = $this->companyRepo->getListMyCompany();

		$sunat_transaction = $model->sunat_transaction;
		$igv_code = $model->igv_code;
		$proof_type = $this->proof_type;
		$document_types = $this->documentTypeRepo->getList2();
		$currencies = $this->currencyRepo->getList('symbol');
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->employeeRepo->getListSellers();
		return view('partials.edit', compact('model','document_types', 'currencies', 'payment_conditions', 'sellers', 'warehouses','items', 'proof_type', 'my_companies', 'sunat_transaction', 'igv_code'));
	}

	public function update($id)
	{
		$this->repo->save(\Request::all(), $id);
		return redirect()->route($this->doc.'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route($this->doc.'.index');
	}
	public function createByCompany($company_id)
	{
		$document_types = $this->documentTypeRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$payment_conditions = $this->paymentConditionRepo->getList();
		$company = $this->companyRepo->findOrFail($company_id);
		return view('partials.create', compact('document_types', 'currencies', 'payment_conditions', 'company'));
	}
	public function getType()
	{
		$this->doc = explode('.', \Request::route()->getName())[0];
		$array = [
			'issuance_vouchers' => 1,
			'reception_vouchers' => 2,
			'issuance_letters' => 3,
			'reception_letters' => 4,
		];
		$this->proof_type = isset($array[$this->doc]) ? $array[$this->doc] : 0;
		return true;
	}
	public function ajaxAutocomplete1($company_id)
	{
		$term = \Input::get('term');
		$models = $this->repo->autocomplete1($term, $company_id);
		$result = [];
		foreach ($models as $model) {
			$result[]=[
				'value' => $model->document_type->name.' '.$model->sn,
				'id' => $model,
				'label' => $model->document_type->name.' '.$model->sn
			];
		}
		return \Response::json($result);
	}
}
