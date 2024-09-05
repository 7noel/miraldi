<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Stock;
use App\Price;
use App\Barcode;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Product::all();
        return view('products.index',compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Product::with('stock', 'price')->where('ACODIGO', $id)->first();
        return view('partials.edit', compact('model'));
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
        $model = Product::where('ACODIGO', $id)->first();
        $model->ACODIGO2 = $data['ACODIGO2'];
        $model->save();
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxAutocomplete()
    {
        
        $term = request()->get('term');
        $models =  Product::with('stock', 'price')->has('price')->has('stock')->where('ACODIGO','like',"%$term%")->orWhere('ADESCRI','like',"%$term%")->get();
        $result=[];
        foreach ($models as $model) {
            if (!is_null($model->stock) and !is_null($model->price) ) {
            //if (!is_null($model->stock) and !is_null($model->price) and $model->stock->STSKDIS > 0) {
                $result[]=[
                    'value' => $model->ADESCRI,
                    'id' => $model,
                    'label' => $model->ACODIGO.'  '.$model->ADESCRI
                ];
            }
        }
        return response()->json($result);
    }

    public function search()
    {
        return view('products.search');
    }

    public function get_search($id)
    {
        $result = Product::with('stock','price','family','lockers')->where('ACODIGO', $id)->orWhere('ACODIGO2', $id)->first();
        return response()->json($result);
    }

    public function excel_codbars()
    {
        $models = Product::all();
        //dd($models);
        return view('products.excel_codbars', compact('models'));
    }

    public function excel_codbars_download()
    {
        $data = request()->all();
        $models = $data['products'];
        return \Excel::download(new ProductsExport('products.export_excel_codbar', $models), 'codigo_barras.xlsx');
    }

    public function codbars_save()
    {
        $data = request()->all();
        if (isset($data['products'])) {
            $models = $data['products'];
        } else {
            $models = [];
        }
        $contador = 0;
        Barcode::truncate();
        foreach ($models as $key => $model) {
            for ($i=0; $i < $model['cantidad']; $i++) { 
                Barcode::create(['code' => $model['codigo'], 'description' => $model['descripcion']]);
                // Barcode::create(['code'=>$model['codigo'], 'description'=>str_replace('"', '\'', $model['descripcion'])]);
                $contador++;
            }
        }
        return redirect()->route('products.excel_codbars');
    }

    public function get_oc($id)
    {
        $id = str_pad($id, 13, "0", STR_PAD_LEFT);
        $result = \DB::connection('sqlsrv')->select('select OC_CCODIGO, OC_NCANTID from COMOVD where OC_CNUMORD = :id', ['id' => $id]);
        return response()->json($result);
    }

    public function update_prices2()
    {
        set_time_limit(240);
        $fecha = request()->input('fecha');
        $prices = \DB::connection('mysql_old')->select("select CodInterno, ValorCompra, GastosAdmin, Utilidad, ValorVenta from stocks where Estado!=0 and (Fecha1 >= ? or Fecha2 >= ?)", [$fecha, $fecha]);
        // $prices = \DB::connection('mysql_old')->select("select CodInterno, ValorCompra, GastosAdmin, Utilidad, ValorVenta from stocks where Estado!=0 and Datos3='' and Fecha1 < :f1 limit 2000", ['f1' => $fecha]);
        // $prices = \DB::connection('mysql_old')->select("select CodInterno, ValorCompra, GastosAdmin, Utilidad, ValorVenta from stocks where Estado!=0 and Datos3=''");
        $count_updates = 0;
        $count_creates = 0;
        // dd($prices);
        // $codes = array_map(function($price){
        //     return $price->CodInterno;
        // }, $prices);
        // $models = Price::where('COD_ARTI', $codes)->get();

        foreach ($prices as $key => $price) {
            $p_l = Price::where('COD_ARTI', $price->CodInterno)->first();
            if ($p_l) {
                // Actualizar Precio Lista
                $p_l->PRE_ANT = $p_l->PRE_ACT;
                $p_l->FLAG_IGVANT = $p_l->FLAG_IGVACT;
                $p_l->FLAG_IGVACT = 0;
                $p_l->PRECIO_BASE = $price->ValorCompra;
                $p_l->POR_GASTOS_ADMINISTRATIVOS = $price->GastosAdmin;
                $p_l->POR_UTILIDAD = $price->Utilidad;
                $p_l->PRE_ACT = $price->ValorVenta;
                $p_l->save();
                $count_updates++;

            } else {
                $p = Product::where('ACODIGO', $price->CodInterno)->first();
                if ($p) {
                    // Crear Precio Lista
                    $agregar = ['COD_LISPRE'=>'0001', 'COD_ARTI'=>$p->ACODIGO, 'PRE_ACT'=>$price->ValorVenta, 'PRE_ANT'=>0, 'DIA_HORA'=>date('Y-d-m H:i:s'), 'USUA_RES'=>'1', 'FLAG_IGVACT'=>0, 'FLAG_IGVANT'=>0, 'UNI_LISPRE'=>$p->AUNIDAD, 'MON_PRE'=>'MN', 'PRECIO_BASE'=>$price->ValorCompra, 'POR_GASTOS_ADMINISTRATIVOS'=>$price->GastosAdmin, 'POR_UTILIDAD'=>$price->Utilidad];
                    $where = ['COD_LISPRE'=>'0001', 'COD_ARTI'=>$p->ACODIGO];

                    $p_l = Price::updateOrCreate($agregar, $where);
                    $count_creates;
                }
            }
            if ($p_l) {
                \DB::connection('mysql_old')->select("update stocks set Datos3='1' where CodInterno = :codigo", ['codigo' => $price->CodInterno]);
            } else {
                \DB::connection('mysql_old')->select("update stocks set Datos3='2' where CodInterno = :codigo", ['codigo' => $price->CodInterno]);
            }
        }
        return "Se actualizaron $count_updates registros y se crearon $count_creates registros";
    }
}
