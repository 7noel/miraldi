<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picking;
use App\PickingDetail;
use App\Product;
use App\Stock;

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
        $currentMinute = date('i');  // 'i' devuelve los minutos actuales

        // Verificar si estamos dentro de los primeros 10 minutos de la hora
        if ($currentMinute >= 0 && $currentMinute <= 9) {
            $p_details = PickingDetail::whereNull('invoiced_at')->get();
            foreach ($p_details as $detail) {
                $factura = \DB::connection('sqlsrv')->table('FACCAB as f')
                    ->join('FACDET as df', function($join) {
                        $join->on('f.CFTD', '=', 'df.DFTD')
                             ->on('f.CFNUMSER', '=', 'df.DFNUMSER')
                             ->on('f.CFNUMDOC', '=', 'df.DFNUMDOC');
                    })
                    ->where('f.CFTD', '!=', 'NC')  // Filtro por número de pedido
                    ->where('f.CFESTADO', 'V')  // Filtro por número de pedido
                    ->where('f.CFNROPED', '=', $detail->CFNUMPED)  // Filtro por número de pedido
                    ->where('df.DFCODIGO', '=', $detail->codigo)  // Filtro por código de producto
                    ->select('f.*','df.DFCANTID')  // Seleccionar todos los campos de la cabecera
                    ->first();

                //Actualizando picking
                if ($factura) {
                    $detail->quantity_invoiced = $factura->DFCANTID;
                    $detail->invoiced_at = $factura->CFFECDOC;
                    $detail->invoice = $factura->CFNUMSER."-".$factura->CFNUMDOC;
                    $detail->save();
                }
            }
        }

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
        // $data['details'] = json_encode($data['details']);
        $data['user_id'] = \Auth::user()->id;

        $model = Picking::updateOrCreate(['id'=>0], $data);

        if (isset($data['details'])) {
            foreach ($data['details'] as $key => $detail) {
                $detail['user_id'] = $data['user_id'];
                $detail['CFNUMPED'] = $data['CFNUMPED'];
                $detail['quantity'] = $detail['es'];
                $detail['quantity_ordered'] = $detail['pl'];
                $detalle = PickingDetail::updateOrCreate(['picking_id' => $model->id, 'codigo' => $detail['codigo']], $detail);
            }
        }

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
        return true;
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
        // return $pdf->stream();
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="picking.pdf"', // Cambia a 'attachment' si quieres forzar descarga
        ]);
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
        $ip_local = "127.0.0.1";
        $port = 5000;
        $printer = "80mm Series Printer";
        $url = "http://$ip_local:$port/print-pdf?pdf_url=$url_pdf&printer_name=$printer";
        $response = \Http::get($url);

        if ($response->successful()) {
            $data = $response->json(); // Obtener los datos en formato JSON
            return $data;
            // Procesar los datos
        } else {
            // Manejar errores
            $error = $response->status();
            return $error;
        }

    }

    public function actulizarDetalles()
    {
        // dd("actulizarDetalles");
        $models = Picking::whereNotNull('detalles')->get();
        foreach ($models as $model) {
            // dd($model);
            foreach ($model->detalles as $detalle) {
                $data['CFNUMPED'] = $model->CFNUMPED;
                $data['user_id'] = $model->user_id;
                $data['codigo2'] = $detalle->codigo2;
                $data['name'] = $detalle->name;
                $data['quantity'] = $detalle->es;
                $data['quantity_ordered'] = $detalle->pl;
                $data['created_at'] = $model->created_at;
                $data['updated_at'] = $model->updated_at;
                PickingDetail::updateOrCreate(['picking_id'=>$model->id, 'codigo'=>$detalle->codigo], $data);
            }
        }
        dd("Se actualizaron los detalles de los pickings");
    }

}
