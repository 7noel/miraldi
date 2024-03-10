<?php
namespace App\Http\Controllers\Operations;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Operations\OrderRepo;
use App\Modules\Finances\PaymentConditionRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Base\CurrencyRepo;
use App\Modules\Finances\BankRepo;

class OrdersController extends Controller {

	protected $repo;
	protected $paymentConditionRepo;
	protected $companyRepo;
	protected $bankRepo;

	public function __construct(OrderRepo $repo, PaymentConditionRepo $paymentConditionRepo, CompanyRepo $companyRepo, BankRepo $bankRepo) {
		$this->repo = $repo;
		$this->paymentConditionRepo = $paymentConditionRepo;
		$this->companyRepo = $companyRepo;
		$this->bankRepo = $bankRepo;
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

		$sellers = $this->companyRepo->getListSellers();
		return view('partials.filter',compact('models', 'filter', 'sellers'));
	}
	public function byQuote($quote_id)
	{
		$action = "generar";
		$model = $this->repo->findOrFail($quote_id);
		//dd($model);
		$quote = $model;
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->companyRepo->getListSellers();
		$repairmens = $this->companyRepo->getListRepairmens();
		$bs = $model->company->branches->pluck('company_name', 'id')->toArray();
		$bs_shipper = ($model->shipper_id > 0) ? $model->shipper->branches->pluck('company_name', 'id')->toArray() : [];
		return view('operations.output_orders.create_by_quote', compact('model', 'payment_conditions', 'sellers', 'repairmens', 'my_companies', 'bs', 'bs_shipper', 'quote', 'action'));
	}

	public function index2()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$action = "create";
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->companyRepo->getListSellers();
		$repairmens = $this->companyRepo->getListRepairmens();
		$bs = ['' => 'Seleccionar'];
		$bs_shipper = ['' => 'Seleccionar'];
		return view('partials.create', compact('payment_conditions', 'sellers', 'repairmens', 'my_companies', 'bs', 'bs_shipper', 'action'));
	}

	public function store()
	{
		$data = request()->all();
		//dd($data);
		$this->repo->save($data);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return redirect()->to($data['last_page']);
		}
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function show($id)
	{
		$action = "show";
		$model = $this->repo->findOrFail($id);
		$quote = $model->quote;
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->companyRepo->getListSellers();
		$repairmens = $this->companyRepo->getListRepairmens();
		$bs = $model->company->branches->pluck('name', 'id')->toArray();
		$bs_shipper = ($model->shipper_id > 0) ? $model->shipper->branches->pluck('company_name', 'id')->prepend('Seleccionar', '') : [''=>'Seleccionar'] ;
		return view('partials.show', compact('model', 'payment_conditions', 'sellers', 'repairmens', 'my_companies', 'bs', 'bs_shipper', 'quote', 'action'));
	}

	public function edit($id)
	{
		$action = "edit";
		$model = $this->repo->findOrFail($id);
		// dd($model->inventory['solicitud']);
		$quote = $model->quote;
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$sellers = $this->companyRepo->getListSellers();
		$repairmens = $this->companyRepo->getListRepairmens();
		$bs = $model->company->branches->pluck('company_name', 'id')->toArray();
		$bs_shipper = ($model->shipper_id > 0) ? $model->shipper->branches->pluck('company_name', 'id')->prepend('Seleccionar', '') : [''=>'Seleccionar'] ;
		return view('partials.edit', compact('model', 'payment_conditions', 'sellers', 'repairmens', 'my_companies', 'bs', 'bs_shipper', 'quote', 'action'));
	}

	public function update($id)
	{
		$data = request()->all();
		// dd($data);
		$this->repo->save($data, $id);
		if (isset($data['last_page']) && $data['last_page'] != '') {
			return redirect()->to($data['last_page']);
		}
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->cancel($id);
		//$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	/**
	 * CREA UN PDF Inventario EN EL NAVEGADOR
	 * @param  [integer] $id [Es el id de la cotizacion]
	 * @return [pdf]     [Retorna un pdf]
	 */
	public function printInventory($id)
	{
		$cuentas = $this->bankRepo->mostrar();
		$model = $this->repo->findOrFail($id);
		//dd($model->seller->company_name);
		// \PDF::setOptions(['isPhpEnabled' => true]);
		$pdf = \PDF::loadView('pdfs.inventory', compact('model', 'cuentas'));
		//$pdf = \PDF::loadView('pdfs.order_pdf', compact('model'));
		return $pdf->stream();
	}
	/**
	 * Envía Correo al generar cotización
	 * @param  Obj $model Modelo de la cotización
	 * @return boolean        Retorna true indicando que se envió con exito
	 */

	/**
	 * CREA UN PDF EN EL NAVEGADOR
	 * @param  [integer] $id [Es el id de la cotizacion]
	 * @return [pdf]     [Retorna un pdf]
	 */
	public function print($id)
	{
		dd("Holaaaaa");
		$cuentas = $this->bankRepo->mostrar();
		$model = $this->repo->findOrFail($id);
		//dd($model->mycompany->company_name);
		// \PDF::setOptions(['isPhpEnabled' => true]);
		$pdf = \PDF::loadView('pdfs.'.$model->order_type, compact('model', 'cuentas'));
		$pdf->setPaper('b7', 'portrait');
		//$pdf = \PDF::loadView('pdfs.order_pdf', compact('model'));
		return $pdf->stream();
	}
	/**
	 * Envía Correo al generar cotización
	 * @param  Obj $model Modelo de la cotización
	 * @return boolean        Retorna true indicando que se envió con exito
	 */
	private function sendAlert($model)
	{
		$data['model'] = $model;
        \Mail::send('emails.notificacion', $data, function($message)
        {
            $message->to('jchu@ddmmedical.com');
            $message->cc(['onavarro@ddmmedical.com', 'asistente@ddmmedical.com']);
            $message->subject('Verificar Cotización');
            $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
        });
	}
	public function createByCompany($company_id)
	{
		$action = "edit";
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$repairmens = $this->companyRepo->getListRepairmens();
		$company = $this->companyRepo->findOrFail($company_id);
		return view('partials.create', compact('payment_conditions', 'currencies', 'sellers', 'repairmens', 'company', 'action'));
	}
}