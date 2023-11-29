<?php namespace App\Http\Controllers\Finances;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Finances\ProofRepo;
use App\Modules\Finances\PaymentConditionRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Storage\WarehouseRepo;
use App\Modules\Operations\OrderRepo;
use App\Modules\Base\TableRepo;
use App\Modules\Finances\BankRepo;

class ProofsController extends Controller {

	protected $repo;
	protected $paymentConditionRepo;
	protected $companyRepo;
	protected $warehouseRepo;
	protected $orderRepo;

	protected $proof_type;
	protected $doc;
	protected $tableRepo;
	protected $bankRepo;

	public function __construct(ProofRepo $repo, PaymentConditionRepo $paymentConditionRepo, CompanyRepo $companyRepo, WarehouseRepo $warehouseRepo, OrderRepo $orderRepo, TableRepo $tableRepo, BankRepo $bankRepo) {
		$this->repo = $repo;
		$this->paymentConditionRepo = $paymentConditionRepo;
		$this->companyRepo = $companyRepo;
		$this->warehouseRepo = $warehouseRepo;
		$this->orderRepo = $orderRepo;
		$this->tableRepo = $tableRepo;
		$this->bankRepo = $bankRepo;

		$this->getType();
	}

	public function index()
	{
		$filter = (object) request()->all();
		if( !((array) $filter) ) {
			$filter->sn = '';
			$filter->placa = '';
			$filter->seller_id = '';
			$filter->status = '';
			$filter->f1 = date('Y-m-d', strtotime('first day of this month'));
			$filter->f2 = date('Y-m-d', strtotime('last day of this month'));
		}
		$models = $this->repo->filter($filter);
		// dd(json_decode($models[1]->response_sunat)->success);

		$sellers = $this->companyRepo->getListSellers();
		return view('partials.filter',compact('models', 'filter', 'sellers'));
	}

	public function issuanceVouchers()
	{
		$models = $this->repo->issuanceVouchers('number', request()->get('name'));
		return view('finances.proofs.issuance_vouchers',compact('models'));
	}

	public function create()
	{
		$action = "create";
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sunat_transaction = 1;
		$igv_code = 1;
		$sellers = $this->companyRepo->getListSellers();
		$documents = $this->tableRepo->getListDoc('document_controls', 'description', 'id');
		return view('partials.create', compact('sellers', 'my_companies', 'sunat_transaction', 'igv_code', 'documents', 'payment_conditions', 'action'));
	}

	public function byOrder($order_id)
	{
		$type = explode('.', request()->route()->action['as'])[0];
		$action = "generar";
		$model = $this->orderRepo->findOrFail($order_id);
		$order = $model;
		// dd($model);
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();

		$sunat_transaction = 1;
		$igv_code = 1;
		// $proof_type = $this->proof_type;
		$sellers = $this->companyRepo->getListSellers();
		$documents = $this->tableRepo->getListDoc('document_controls', 'description', 'id');
		if ($type == 'input_vouchers') {
			return view('finances.input_vouchers.create_by_order', compact('model', 'order_id', 'sellers', 'my_companies', 'sunat_transaction', 'igv_code', 'order', 'documents', 'payment_conditions', 'action'));
		} elseif ($type == 'output_vouchers') {
			return view('finances.output_vouchers.create_by_order', compact('model', 'order_id', 'sellers', 'my_companies', 'sunat_transaction', 'igv_code', 'order', 'documents', 'payment_conditions', 'action'));
		} else {
			return dd(request()->route()->action['as']);
		}
		
		//dd(\Request::route()->action['as']);
	}

	public function index2()
	{
		$models = $this->repo->index('sn', request()->get('name'), $this->proof_type);
		return view('partials.index',compact('models'));
	}

	public function store()
	{
		//dd(\Request::all());
		$this->repo->save(request()->all());
		return redirect()->route($this->doc.'.index');
	}

	public function show($id)
	{
		$action = "show";
		$model = $this->repo->findOrFail($id);
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();

		$sunat_transaction = $model->sunat_transaction;
		$igv_code = $model->igv_code;
		// $proof_type = $this->proof_type;
		$sellers = $this->companyRepo->getListSellers();
		$documents = $this->tableRepo->getListDoc('document_controls', 'description', 'id');
		return view('partials.show', compact('model', 'sellers', 'my_companies', 'sunat_transaction', 'igv_code', 'documents', 'payment_conditions', 'action'));
	}

	public function edit($id)
	{
		$action = "edit";
		$model = $this->repo->findOrFail($id);
		// dd($model->document_type->code);
		//$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();

		$sunat_transaction = $model->sunat_transaction;
		$igv_code = $model->igv_code;
		// $proof_type = $this->proof_type;
		$sellers = $this->companyRepo->getListSellers();
		$documents = $this->tableRepo->getListDoc('document_controls', 'description', 'id');
		return view('partials.edit', compact('model', 'sellers', 'sunat_transaction', 'igv_code', 'documents', 'payment_conditions', 'action'));
	}

	public function update($id)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route($this->doc.'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->cancel($id);
		// $model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}
	public function createByCompany($company_id)
	{
		$document_types = $this->documentTypeRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$payment_conditions = $this->paymentConditionRepo->getList();
		$company = $this->companyRepo->findOrFail($company_id);
		$documents = $this->tableRepo->getListDoc('document_controls', 'description', 'id');
		return view('partials.create', compact('document_types', 'currencies', 'payment_conditions', 'company', 'documents'));
	}
	public function getType()
	{
		$this->doc = explode('.', request()->route()->getName())[0];
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
		return response()->json($result);
	}

	/**
	 * CREA UN PDF EN EL NAVEGADOR
	 * @param  [integer] $id [Es el id de la cotizacion]
	 * @return [pdf]     [Retorna un pdf]
	 */
	public function print2($id)
	{
		$cuentas = $this->bankRepo->mostrar();
		$model = $this->repo->findOrFail($id);
		$r = json_decode($model->response_sunat);
		$nombre = (isset($r->data->filename)) ? $r->data->filename : $nombre = $model->sn;
		$pdf = \PDF::loadView('pdfs.output_vouchers', compact('model', 'cuentas', 'r'));
		return $pdf->stream($nombre.".pdf");
	}
	public function print($id)
	{
		// $model = $this->repo->cancel($id);
		// dd($model);
		$model = $this->repo->findOrFail($id);
		$r = json_decode($model->response_sunat);
		//dd(json_decode($model->response_sunat)->links);
		$r = json_decode($model->response_sunat);
		return response(file_get_contents($r->links->pdf), 200, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="'.$r->data->filename.".pdf".'"'
		]);
	}
	public function input_vouchers_print($id)
	{
		$cuentas = $this->bankRepo->mostrar();
		$model = $this->repo->findOrFail($id);
		$nombre = $model->sn;
		$pdf = \PDF::loadView('pdfs.input_vouchers', compact('model', 'cuentas'));
		return $pdf->stream($nombre.".pdf");
	}
	public function send_email_cpe()
	{
		$data = request()->all();
		$id = $data['cpe'];
		$email = $data['email'];
		$model = $this->repo->findOrFail($id);
		$r = json_decode($model->response_sunat);
		$data['model'] = $model;
		$data['r'] = $r;
		// dd($email);
		// return 'correo enviado x';
		\Mail::send('emails.message', $data, function($message) use ($model, $r,$email)
		{
			$message->to($email, $model->company->company_name);
			$message->sender(env('CONTACT_MAIL'));
			$message->subject('Envio de Comprobante de Pago Electrónico');
			$message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
		});
		echo $icons['pdf'];
		return 'correo enviado';
	}
	public function get_json_cpe($id)
	{
		$model = $this->repo->findOrFail($id);
		return response()->json($model);
	}
}
