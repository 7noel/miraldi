<?php
namespace App\Http\Controllers\Sales;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Sales\OrderRepo;
use App\Modules\Finances\PaymentConditionRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Base\CurrencyRepo;
use App\Modules\HumanResources\EmployeeRepo;

class OrdersController extends Controller {

	protected $repo;
	protected $paymentConditionRepo;
	protected $currencyRepo;
	protected $employeeRepo;
	protected $companyRepo;

	public function __construct(EmployeeRepo $employeeRepo, OrderRepo $repo, PaymentConditionRepo $paymentConditionRepo, CurrencyRepo $currencyRepo, CompanyRepo $companyRepo) {
		$this->repo = $repo;
		$this->paymentConditionRepo = $paymentConditionRepo;
		$this->currencyRepo = $currencyRepo;
		$this->employeeRepo = $employeeRepo;
		$this->companyRepo = $companyRepo;
	}
	public function index()
	{
		//dd(\Request::all());
		if (explode('.', \Request::route()->getName())[0] == 'purchase_orders') {
			$order_type = 3;
		} elseif (explode('.', \Request::route()->getName())[0] == 'quotes') {
			$order_type = 2;
		} else {
			$order_type = 1;
		}
		$filter = (object) \Request::all();
		if( !((array) $filter) ) {
			$filter->sn = '';
			$filter->seller_id = '';
			$filter->status = '';
			$filter->f1 = date('Y-m-d', strtotime('first day of this month'));
			$filter->f2 = date('Y-m-d', strtotime('last day of this month'));
		}
		$models = $this->repo->filter($filter, $order_type);

		$sellers = $this->employeeRepo->getListSellers();
		$payment_conditions = $this->paymentConditionRepo->getList();
		return view('partials.filter',compact('models', 'filter', 'sellers'));
	}
	public function byQuote($quote_id)
	{
		$model = $this->repo->findOrFail($quote_id);
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$bs = $model->company->branches->pluck('name', 'id')->prepend('Seleccionar', '');
		$bs_shipper = ($model->shipper_id > 0) ? $model->shipper->branches->pluck('name', 'id')->prepend('Seleccionar', '') : [''=>'Seleccionar'];
		return view('partials.create', compact('model', 'payment_conditions', 'currencies', 'sellers', 'my_companies', 'bs', 'bs_shipper', 'quote_id'));
	}

	public function index2()
	{
		$models = $this->repo->index('name', \Request::get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$bs = ['' => 'Seleccionar'];
		$bs_shipper = ['' => 'Seleccionar'];
		return view('partials.create', compact('payment_conditions', 'currencies', 'sellers', 'my_companies', 'bs', 'bs_shipper'));
	}

	public function store()
	{
		$model = $this->repo->save(\Request::all());
		//$this->sendAlert($model);
		return \Redirect::route(explode('.', \Request::route()->getName())[0].'.index');
	}

	public function show($id)
	{
		$model = $this->repo->findOrFail($id);
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$bs = $model->company->branches->pluck('name', 'id')->prepend('Seleccionar', '');
		$bs_shipper = ($model->shipper_id > 0) ? $model->shipper->branches->pluck('name', 'id')->prepend('Seleccionar', '') : [''=>'Seleccionar'] ;
		return view('partials.show', compact('model', 'payment_conditions', 'currencies', 'sellers', 'my_companies', 'bs', 'bs_shipper'));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$bs = $model->company->branches->pluck('name', 'id')->prepend('Seleccionar', '');
		$bs_shipper = ($model->shipper_id > 0) ? $model->shipper->branches->pluck('name', 'id')->prepend('Seleccionar', '') : [''=>'Seleccionar'] ;
		return view('partials.edit', compact('model', 'payment_conditions', 'currencies', 'sellers', 'my_companies', 'bs', 'bs_shipper'));
	}

	public function update($id)
	{
		$this->repo->save(\Request::all(), $id);
		return \Redirect::route(explode('.', \Request::route()->getName())[0].'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (\Request::ajax()) {	return $model; }
		return redirect()->route(explode('.', \Request::route()->getName())[0].'.index');
	}

	/**
	 * CREA UN PDF EN EL NAVEGADOR
	 * @param  [integer] $id [Es el id de la cotizacion]
	 * @return [pdf]     [Retorna un pdf]
	 */
	public function print($id)
	{
		$model = $this->repo->findOrFail($id);
		\PDF::setOptions(['isPhpEnabled' => true]);
		$pdf = \PDF::loadView('pdfs.order', compact('model'));
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
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$company = $this->companyRepo->findOrFail($company_id);
		return view('partials.create', compact('payment_conditions', 'currencies', 'sellers', 'company'));
	}
}