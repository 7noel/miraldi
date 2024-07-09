<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picking;
use App\Product;

class PickingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->get('name');
        if ($search) {
            $models = Picking::name($search)->orderBy("id", 'DESC')->paginate();
        } else {
            $models = Picking::orderBy('id', 'DESC')->paginate();
        }

        return view('partials.index',compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pickings.create');
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
        $data['CFNUMPED'] = str_pad($data['CFNUMPED'], 7, "0", STR_PAD_LEFT);
        $data['details'] = json_encode($data['details']);
        $data['user_id'] = \Auth::user()->id;
        // dd($data);
        $model = Picking::create($data);
        // dd($model);
        return redirect()->route('pickings.show', $model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Picking::with('order', 'user')->where('id', $id)->first();
        return view('partials.show', compact('model'));
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
        $model = Picking::findOrFail($id);
        $pdf = \PDF::loadView('pdfs.pickings', compact('model'))->setPaper([0,0,227,2000], 'portrait');
        return $pdf->stream();
    }
    public function print_note($id)
    {
        $model = Order::findOrFail($id);
        $pdf = \PDF::loadView('pdfs.notes', compact('model'))->setPaper([0,0,227,2000], 'portrait');
        return $pdf->stream();
    }

    public function picking()
    {
        return view('orders.picking');
    }

    // public function get_picking($qr)
    // {
    //     $vals = explode('|', $qr);
    //     $order_id = array_shift($vals);
    //     $data['order'] = Order::findOrFail($order_id);
    //     $p_ids=[];
    //     foreach ($vals as $key => $val) {
    //         $p_ids[] = explode(' ', $val)[0];
    //     }
    //     $data['products'] = Product::with('lockers')->whereIn('ACODIGO', $p_ids)->get();
    //     return response()->json($data);
    // }
    // 
    // public function prepareData($data)
    // {
    //     $last_ot = Order::orderBy('CFNUMPED','desc')->first();
    //     $data['CFNUMPED'] = str_pad((intval($last_ot->CFNUMPED) + 1), 7, "0", STR_PAD_LEFT);
    //     $data['CFPUNVEN'] = '01';
    //     $data['CFESTADO'] = 'V';
    //     $data['CFCOTIZA'] = 'EMITIDO';
    //     $data['TIPO'] = 'PD';
    //     $data['CFFECDOC'] = date('Y-d-m H:i:s');
    //     $data['CFFECVEN'] = date('Y-d-m H:i:s');
    //     $data['CFCODMON'] = 'MN';
    //     $data['CFUSER'] = \Auth::user()->user_code;

    //     return $data;
    // }
}
