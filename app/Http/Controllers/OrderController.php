<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Seller;
use App\Product;
use App\Condition;
use App\Company;
use App\Original;
use App\PickingDetail;

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
        if( !isset($filter->sn) ) {
            $filter->sn = '';
            $filter->seller_id = '';
            $filter->company_id = '';
            $filter->txtCompany = '';
        }
        if (isset($filter->txtCompany) && trim($filter->txtCompany) == '') {
            $filter->company_id = '';
        }

        $q = Order::with('seller', 'company', 'original');
        if (\Auth::user()->role_id == 2) {
            $q->where('CFVENDE', \Auth::user()->seller_code);
        }
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
        if (\Auth::user()->role_id == 2) {
            $sellers = Seller::where('COD_VEN', \Auth::user()->seller_code)->pluck('DES_VEN', 'COD_VEN')->toArray();
        } else {
            $sellers = ['' => 'Seleccionar'] + Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        }
        
            // $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        return view('partials.filter',compact('models', 'filter', 'sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cambio = \DB::connection('starsoft2')->table('TIPO_CAMBIO_SUNAT')->where('VENTA', '>', 0)->orderBy('FECHA', 'desc')->first();
        $conditions = Condition::all()->pluck('DES_FP', 'COD_FP')->toArray();
        if (\Auth::user()->role_id == 2) {
            $sellers = Seller::where('COD_VEN', \Auth::user()->seller_code)->pluck('DES_VEN', 'COD_VEN')->toArray();
        } else {
            $sellers = ['' => 'Seleccionar'] + Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        }
        $bloquea_original = false;
        $graba_original = true;
        return view('partials.create', compact('conditions', 'sellers', 'cambio', 'bloquea_original', 'graba_original'));
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
        $last_ot = Order::orderBy('CFNUMPED', 'desc')->first();
        $data['CFNUMPED'] = str_pad(($last_ot->CFNUMPED + 1), 7, "0", STR_PAD_LEFT);
        $data['TIPO'] = 'PD';
        $data['CFFECDOC'] = date('Y-d-m H:i:s');
        $data['CFFECVEN'] = date('Y-d-m H:i:s');
        $data = $this->prepareData($data);
        $model = Order::create($data);
        // Graba el pedido original
        $this->saveOriginal($data);

        if (isset($data['details'])) {
            foreach ($data['details'] as $key => $detail) {
                OrderDetail::create($detail);
            }
        }

        return redirect()->route( 'orders.edit' , $data['CFNUMPED']);
        
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
        if (\Auth::user()->role_id == 2) {
            $sellers = Seller::where('COD_VEN', \Auth::user()->seller_code)->pluck('DES_VEN', 'COD_VEN')->toArray();
        } else {
            $sellers = ['' => 'Seleccionar'] + Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        }
        // $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
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
        if (\Auth::user()->role_id == 2) {
            $sellers = Seller::where('COD_VEN', \Auth::user()->seller_code)->pluck('DES_VEN', 'COD_VEN')->toArray();
        } else {
            $sellers = ['' => 'Seleccionar'] + Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();
        }
        // $sellers = Seller::all()->pluck('DES_VEN', 'COD_VEN')->toArray();

        if ($model->CFCOTIZA == 'EMITIDO') {
            $bloquea_original = false;
            if (isset($model->original) and ($model->original->read_only or $model->original->activated_at)) { // esta readonly o bloqueado
                $graba_original = false;
            } else {
                $graba_original = true;
            }
        } else {
            $bloquea_original = true;
            $graba_original = false;
        }

        return view('partials.edit', compact('model', 'conditions', 'sellers', 'bloquea_original', 'graba_original'));
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
        $data['CFNUMPED'] = $id;
        $status_before = $data['CFCOTIZA'];
        $data = $this->prepareData($data);
        $data['CFCOTIZA'] = $status_before;
        Order::updateOrCreate(['CFNUMPED' => $id], $data);
        // Graba el pedido original
        if ($data['graba_original']) {
            $this->saveOriginal($data);
        }
        if ($data['bloquea_original']) {
            Original::where('CFNUMPED', $id)->update(['read_only'=>true]);
        }


        $old_ids = OrderDetail::where('DFNUMPED', $id)->pluck('DFCODIGO')->toArray();
        $toDelete = array_diff($old_ids, $data['ids']);
        // dd($toDelete);
        if (isset($toDelete) and count($toDelete)>0) {
            // dd('DENTRO de delete');
            OrderDetail::where('DFNUMPED', $id)->whereIn('DFCODIGO', $toDelete)->delete();
        }
        // dd('fuera de delete');
        if (isset($data['details'])) {
            foreach ($data['details'] as $key => $detail) {
                if (in_array($detail['DFCODIGO'], $old_ids)) {
                    OrderDetail::where('DFNUMPED', $id)->where('DFCODIGO', $detail['DFCODIGO'])->update($detail);
                } else {
                    OrderDetail::create($detail);
                }
            }
        }
        // Si la peticion es ajax
        if (request()->ajax()) {
            $message = "Los datos se guardaron correctamente";
            return response()->json(['id' => $id, 'message' => $message]);
        }
        
        return redirect()->route( 'orders.show' , $id);

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
    public function print_original($id)
    {
        $model = Order::findOrFail($id);
        $pdf = \PDF::loadView('pdfs.original', compact('model'));
        return $pdf->stream();
    }

    public function activar_pedido($id)
    {
        $model = Original::where('CFNUMPED', $id)->first();
        $model->activated_at = date('Y-m-d H:i:s');
        $model->read_only = '1';
        $model->save();
        return redirect()->route( 'orders.show' , $id);
    }

    public function por_comprar()
    {
        $fechaLimite = date('Y-d-m 00:00:00', strtotime('-15 days'));
        $models = \DB::connection('sqlsrv')->table('PEDDET')
            ->join('MAEART', 'PEDDET.DFCODIGO', '=', 'MAEART.ACODIGO')
            ->join('PEDCAB', 'PEDCAB.CFNUMPED', '=', 'PEDDET.DFNUMPED')
            ->join('STKART', 'PEDDET.DFCODIGO', '=', 'STKART.STCODIGO')
            ->where('PEDCAB.CFFECDOC', '>=', $fechaLimite)
            ->where('PEDCAB.CFCOTIZA', 'AUTORIZADO')
            ->select('MAEART.ACODIGO', 'MAEART.ADESCRI', 'MAEART.AUNIDAD', 'STKART.STSKDIS',
                \DB::raw('STRING_AGG(PEDCAB.CFNUMPED, \', \') as numeros_pedidos'),
                \DB::raw('SUM(PEDDET.DFCANTID) as total_cantidad'),
                \DB::raw('SUM(PEDDET.DFCANTID) - STKART.STSKDIS as diferencia'))
            ->distinct()
            ->groupBy('MAEART.ACODIGO', 'MAEART.ADESCRI', 'MAEART.AUNIDAD', 'STKART.STSKDIS')
            ->havingRaw('SUM(PEDDET.DFCANTID) - STKART.STSKDIS > 0') // Filtrar registros con diferencia mayor a cero
            ->orderBy('diferencia', 'desc')
            ->get();
        return view('products.por_comprar', compact('models'));
    }

    public function get_picking($qr)
    {
        // Define la fecha límite
        $fechaLimite = date('Y-m-d 00:00:00', strtotime('-15 days'));

        // Extrae el order_id y los códigos de producto
        $vals = explode('|', $qr);
        $order_id = str_pad(array_shift($vals), 7, "0", STR_PAD_LEFT);
        $data['order'] = Order::findOrFail($order_id);

        // Obtiene los códigos de producto
        $p_ids = collect($vals)->map(function ($val) {
            return explode(' ', $val)[0];
        });

        // Carga productos relacionados
        $data['products'] = Product::with('lockers', 'stock')->whereIn('ACODIGO', $p_ids)->get();

        // Inicializa resultados con 0
        $resultados = array_fill_keys($p_ids->toArray(), 0);
/*
        // Realiza una sola consulta para todos los códigos de productos
        $pickings = \DB::table('pickings')
            ->where(function ($query) use ($p_ids) {
                foreach ($p_ids as $codigoProducto) {
                    $query->orWhereRaw("JSON_CONTAINS(details, JSON_OBJECT('codigo', ?))", [$codigoProducto]);
                }
            })
            ->where('is_invoiced', 0)
            ->where('created_at', '>=', $fechaLimite)
            ->get();

        // Sumar pl para cada código
        foreach ($pickings as $picking) {
            $detalles = json_decode($picking->details);

            foreach ($detalles as $item) {
                if (isset($resultados[$item->codigo])) { // Solo sumar si el código existe en resultados
                    $resultados[$item->codigo] += $item->pl; // Acumula el valor de pl
                }
            }
        }
*/
        // Obteniendo los productos en pickings
        // Filtrar registros que coincidan con los códigos de producto y cuyo campo invoiced_at sea null
        $picking_details = PickingDetail::whereIn('codigo', $p_ids)
                                   ->whereNull('invoiced_at')
                                   ->where('created_at', '>=', $fechaLimite)
                                   ->groupBy('codigo')
                                   ->selectRaw('codigo, SUM(quantity) as total_quantity')
                                   ->get();
        
        // Inicializar un array con todos los códigos de producto a 0
        // $resultados = array_fill_keys($p_ids->toArray(), 0);
        
        // Actualizar los valores en $resultados con las sumas obtenidas
        foreach ($picking_details as $detail) {
            $resultados[$detail->codigo] = $detail->total_quantity;
        }

        $data['in_pickings'] = $resultados;

        return response()->json($data);
    }
    public function prepareData($data)
    {
        // dd($data);
        // $last_ot = Order::orderBy('CFNUMPED','desc')->first();
        // $data['CFNUMPED'] = str_pad((intval($last_ot->CFNUMPED) + 1), 7, "0", STR_PAD_LEFT);
        $data['CFPORDESES'] = 0;
        $data['CFPUNVEN'] = '01';
        $data['CFESTADO'] = 'V';
        $data['CFCOTIZA'] = 'EMITIDO';
        $data['ids'] = [];
        // $data['CFCODMON'] = 'MN';
        $data['CFUSER'] = \Auth::user()->user_code;
        $data['CFIMPORTE'] = 0;
        $data['CFDESVAL'] = 0;
        $data['CFIGV'] = 0;
        $item = 0;
        $vbruto = 0;
        if (isset($data['details'])) {
            foreach ($data['details'] as $key => $detail) {
                $item += 1;
                unset($data['details'][$key]['value']);
                unset($data['details'][$key]['price']);
                unset($data['details'][$key]['CFPORDESCL']);
                $data['details'][$key]['DFNUMPED'] = $data['CFNUMPED'];
                $data['details'][$key]['DFSECUEN'] = str_pad((intval($item)), 3, "0", STR_PAD_LEFT);
                // $data['details'][$key]['DFDESCRI'] = 
                $data['details'][$key]['DFIGVPOR'] = 18;
                $data['details'][$key]['DFARTIGV'] = 0;
                // $igv_por = $data['details'][$key]['DFIGVPOR'];
                $igv_dec = $data['details'][$key]['DFIGVPOR']/100;
                $data['details'][$key]['DFALMA'] = '01';
                $data['details'][$key]['DFSALDO'] = $detail['DFCANTID'];

                $vbruto += round($detail['DFCANTID']*$detail['DFPREC_ORI'], 2); // valor bruto
                $vventa = $detail['DFCANTID']*$detail['DFPREC_ORI']; // valor de item antes del descuento
                $data['details'][$key]['DFDESCLI'] = $vventa*$data['CFPORDESCL']/100;
                $vventa = round($vventa - $data['details'][$key]['DFDESCLI'], 6); // valor de item luego del descuento cliente
                $data['details'][$key]['DFDESESP'] = $vventa*$data['CFPORDESES']/100;
                $vventa = round($vventa - $data['details'][$key]['DFDESESP'], 6); // valor de item luego del descuento especial
                $data['details'][$key]['DFDESCTO'] = $vventa*$detail['DFPORDES']/100;
                $vventa = round($vventa - $data['details'][$key]['DFDESCTO'], 6); // valor de item luego del descuento por item
                $pitem = round((1+$igv_dec)*$vventa, 6);
                $data['details'][$key]['DFPREC_VEN'] = $pitem/$detail['DFCANTID'];
                $data['details'][$key]['DFIGV'] = $pitem - $vventa;
                if ($data['CFCODMON']=='MN') {
                    $data['details'][$key]['DFIMPUS'] = round($pitem/$data['CFTIPCAM'], 6);
                    $data['details'][$key]['DFIMPMN'] = $pitem;
                } else {
                    $data['details'][$key]['DFIMPUS'] = $pitem;
                    $data['details'][$key]['DFIMPMN'] = round($pitem*$data['CFTIPCAM'], 6);
                }
                $data['CFIMPORTE'] += $pitem;
                $data['CFDESVAL'] += $data['details'][$key]['DFDESCLI'] + $data['details'][$key]['DFDESESP'] + $data['details'][$key]['DFDESCTO'];
                $data['CFIGV'] += $data['details'][$key]['DFIGV'];

                $data['ids'][] = $detail['DFCODIGO'];
            }
            $data['CFIMPORTE'] = round($data['CFIMPORTE'], 2);
            $data['CFDESVAL'] = round($data['CFDESVAL'], 2);
            $subtotal = round($vbruto - $data['CFDESVAL'], 2);
            $data['CFIGV'] = round($data['CFIMPORTE'] - $subtotal, 2);
        }
        return $data;
    }

    public function saveOriginal($data)
    {
        $array['CFNUMPED'] = $data['CFNUMPED'];
        $array['discount_2'] = $data['discount_2'];
        $array['content'] = $data;

        $where = ['CFNUMPED' => $data['CFNUMPED']];
        return Original::updateOrCreate($where, $array);
    }

}
