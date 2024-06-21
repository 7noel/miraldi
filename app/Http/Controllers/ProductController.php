<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Stock;
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
        //
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
        //
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
        //
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
        //dd($models);
        //return response()->json($data);
        return \Excel::download(new ProductsExport('products.export_excel_codbar', $models), 'codigo_barras.xlsx');

        /*return \Excel::create('codigo_barras', function($excel) use ($models){
            $excel->sheet('Hoja1', function($sheet) use($models) {
                $sheet->loadView('products.partials.table_report_warehouse', compact('models'));
            });
        })->export('xlsx');*/
    }
    public function codbars_save()
    {
        $data = request()->all();
        $models = $data['products'];
        $contador = 0;
        Barcode::truncate();
        foreach ($models as $key => $model) {
            for ($i=0; $i < $model['cantidad']; $i++) { 
                Barcode::create(['code'=>$model['codigo'], 'description'=>$model['descripcion']]);
                $contador++;
            }
        }
        return redirect()->route('products.excel_codbars');
        return response()->json(['code'=>'1', 'message'=>"Se guardaron $contador registros"]);
    }
    public function get_oc($id)
    {
        $id = str_pad($id, 13, "0", STR_PAD_LEFT);
        $result = \DB::connection('sqlsrv')->select('select OC_CCODIGO, OC_NCANTID from COMOVD where OC_CNUMORD = :id', ['id' => $id]);
        return response()->json($result);
    }
}
