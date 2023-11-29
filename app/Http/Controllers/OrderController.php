<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Seller;
use App\Product;
use App\Condition;
use App\Company;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = (object) request()->all();
        if( !((array) $filter) ) {
            $filter->sn = '';
            $filter->seller_id = '';
            $filter->company_id = '';
            $filter->txtCompany = '';
        }
        if (isset($filter->txtCompany) && trim($filter->txtCompany) == '') {
            $filter->company_id = '';
        }

        $q = Order::with('seller', 'company');
        if ($filter->sn > 0) {
            $models = $q->where('CFNUMPED', str_pad($filter->sn, 7, "0", STR_PAD_LEFT))->orderBy('CFNUMPED', 'desc')->paginate();
        } else {
            if(isset($filter->seller_id) && $filter->seller_id != '') {
                $q->where('CFVENDE', $filter->seller_id);
            }
            if(isset($filter->company_id) && $filter->company_id != '') {
                $q->where('CFCODCLI', $filter->company_id);
            }
            $models = $q->orderBy('CFNUMPED', 'desc')->paginate();
        }
        $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        return view('partials.filter',compact('models', 'filter', 'sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cambio = \DB::connection('starsoft2')->table('TIPO_CAMBIO_SUNAT')->orderBy('FECHA', 'desc')->first();
        $conditions = Condition::all()->pluck('DES_FP', 'COD_FP')->toArray();
        $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        return view('partials.create', compact('conditions', 'sellers', 'cambio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->all();
        $data = $this->prepareData($data);
        dd($data);
        Order::updateOrCreate(['CFNUMPED' => 0], $data);
        if (isset($data['last_page']) && $data['last_page'] != '') {
            return redirect()->to($data['last_page']);
        }
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Order::findOrFail($id);
        $conditions = Condition::all()->pluck('DES_FP', 'COD_FP')->toArray();
        $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        return view('partials.show', compact('model', 'conditions', 'sellers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Order::findOrFail($id);
        $conditions = Condition::all()->pluck('DES_FP', 'COD_FP')->toArray();
        $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        return view('partials.edit', compact('model', 'conditions', 'sellers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->all();
        Order::updateOrCreate(['CFNUMPED' => $id], $data);
        if (isset($data['last_page']) && $data['last_page'] != '') {
            return redirect()->to($data['last_page']);
        }
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Order::findOrFail($id);
        $model->delete();
        $message = 'El pedido fue eliminado';
        if (\Request::ajax()) {
            return response()->json(['id' => $model->CFNUMPED, 'message' => $message]);
        }
        if (request()->ajax()) { return $model; }
        \Session::flash('message', $message);
        return redirect()->route('orders.index');
    }

    /**
     * CREA UN PDF EN EL NAVEGADOR
     * @param  [integer] $id [Es el id de la cotizacion]
     * @return [pdf]     [Retorna un pdf]
     */
    public function print($id)
    {
        $model = Order::findOrFail($id);
        $pdf = \PDF::loadView('pdfs.orders', compact('model'));
        return $pdf->stream();
    }
    public function print_note($id)
    {
        $model = Order::findOrFail($id);
        $pdf = \PDF::loadView('pdfs.notes', compact('model'));
        return $pdf->stream();
    }

    public function picking()
    {
        return view('orders.picking');
    }

    public function get_picking($qr)
    {
        $vals = explode('|', $qr);
        $order_id = array_shift($vals);
        $data['order'] = Order::findOrFail($order_id);
        $p_ids=[];
        foreach ($vals as $key => $val) {
            $p_ids[] = explode(' ', $val)[0];
        }
        $data['products'] = Product::whereIn('ACODIGO', $p_ids)->get();
        return response()->json($data);
    }
    public function prepareData($data)
    {
        $last_ot = Order::orderBy('CFNUMPED','desc')->first();
        $data['CFNUMPED'] = str_pad((intval($last_ot->CFNUMPED) + 1), 7, "0", STR_PAD_LEFT);
        $data['CFPUNVEN'] = '01';
        $data['CFESTADO'] = 'V';
        $data['CFCOTIZA'] = 'EMITIDO';
        $data['TIPO'] = 'PD';
        $data['CFFECDOC'] = date('Y-d-m H:i:s');
        $data['CFFECVEN'] = date('Y-d-m H:i:s');
        $data['CFCODMON'] = 'MN';
        $data['CFUSER'] = \Auth::user()->user_code;

        return $data;
    }
}
