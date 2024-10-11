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

    public function pdf_to_print($id)
    {
        $url_pdf = route( 'pickings.print' , $id );
        $ip_local = "192.168.1.101";
        $port = 5000;
        $printer = "80mm Series Printer";
        $url = "http://$ip_local:$port/print-pdf?pdf_url=$url_pdf&printer_name=$printer";
        $response = \Http::get($url);

        if ($response->successful()) {
            $data = $response->json(); // Obtener los datos en formato JSON
            // Procesar los datos
        } else {
            // Manejar errores
            $error = $response->status();
        }

    }

}
