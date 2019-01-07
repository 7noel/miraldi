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
	public function filter()
	{
		if (explode('.', \Request::route()->getName())[0] == 'quotes') {
			$order_type = 1;
		} else {
			$order_type = 2;
		}
		
		$filter = (object) \Request::all();
		if( !((array) $filter) ) {
			$filter->sn = '';
			$filter->seller_id = '';
			$filter->status = '';
			$filter->f1 = date('Y-m-d');
			$filter->f2 = date('Y-m-d');
		}
		$models = $this->repo->filter($filter, $order_type);

		$sellers = $this->employeeRepo->getListSellers();
		$payment_conditions = $this->paymentConditionRepo->getList();
		return view('partials.filter',compact('models', 'filter', 'sellers'));
	}
	public function index()
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
		return view('partials.create', compact('payment_conditions', 'currencies', 'sellers', 'my_companies'));
	}

	public function store()
	{
		$model = $this->repo->save(\Request::all());
		//$this->sendAlert($model);
		return \Redirect::route(explode('.', \Request::route()->getName())[0].'.filter');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$my_companies = $this->companyRepo->getListMyCompany();
		$payment_conditions = $this->paymentConditionRepo->getList();
		$currencies = $this->currencyRepo->getList('symbol');
		$sellers = $this->employeeRepo->getListSellers();
		$details = [];
		return view('partials.edit', compact('model', 'payment_conditions', 'currencies', 'sellers', 'my_companies'));
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
		return redirect()->route(explode('.', \Request::route()->getName())[0].'.filter');
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