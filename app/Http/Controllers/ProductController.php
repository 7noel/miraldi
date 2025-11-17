<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PickingDetail;
use App\Product;
use App\Stock;
use App\Price;
use App\Barcode;
use App\Locker;
use App\Exports\ProductsExport;
use App\Fpdf\PriceList;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $models = Product::all();
        return view('products.index');
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
        $model = Product::findOrFail($id);
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
        $model = Product::with('stocks', 'price')->where('ACODIGO', $id)->first();
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
        // dd($data);
        $model = Product::where('ACODIGO', $id)->first();
        $model->ACODIGO2 = $data['ACODIGO2']; // actualiza el codigo del fabricante
        $p_l = Price::where('COD_ARTI', $model->ACODIGO)->where('COD_LISPRE', '0001')->first();
        // Solo actualiza precio si tiene precio base
        if (isset($data['PRECIO_BASE'])) {
            $base = $data['PRECIO_BASE'];
            $admin = $data['POR_GASTOS_ADMINISTRATIVOS'];
            $utilidad = $data['POR_UTILIDAD'];
            $precio = round($base * (100 + $admin) * (100 + $utilidad) / 10000, 2);
            if ($p_l) {
                // Actualizar Precio Lista
                if ($precio != $p_l->PRE_ACT or $p_l->POR_UTILIDAD != $utilidad) {
                    $p_l->PRE_ANT = $p_l->PRE_ACT;
                    $p_l->FLAG_IGVANT = $p_l->FLAG_IGVACT;
                    $p_l->FLAG_IGVACT = 0;
                    $p_l->PRECIO_BASE = $base;
                    $p_l->POR_GASTOS_ADMINISTRATIVOS = $admin;
                    $p_l->POR_UTILIDAD = $utilidad;
                    $p_l->PRE_ACT = $precio;
                    $p_l->save();
                }
            } else {
                if ($model) {
                    // Crear Precio Lista
                    $agregar = ['COD_LISPRE'=>'0001', 'COD_ARTI'=>$model->ACODIGO, 'PRE_ACT'=>$precio, 'PRE_ANT'=>0, 'DIA_HORA'=>date('Y-d-m H:i:s'), 'USUA_RES'=>'1', 'FLAG_IGVACT'=>0, 'FLAG_IGVANT'=>0, 'UNI_LISPRE'=>$model->AUNIDAD, 'MON_PRE'=>'MN', 'PRECIO_BASE'=>$base, 'POR_GASTOS_ADMINISTRATIVOS'=>$admin, 'POR_UTILIDAD'=>$utilidad];
                    $where = ['COD_LISPRE'=>'0001', 'COD_ARTI'=>$model->ACODIGO];
                    $p_l = Price::updateOrCreate($where, $agregar);
                }
            }
        }

        if (isset($data['TCASILLERO'])) {
            $ubi = Locker::where('TCODALM', '01')->where('TCODART', $model->ACODIGO)->first();
            $where = ['TCODALM'=>'01', 'TCODART'=>$model->ACODIGO];
            $agregar = ['TCODALM'=>'01', 'TCODART'=>$model->ACODIGO, 'TCASILLERO'=>trim($data['TCASILLERO'])];
            if (is_null($ubi)) { // No existe ubicacion
                if (trim($data['TCASILLERO']) != '') {
                    //dd("No existe ubicacion");
                    $ubi = Locker::updateOrCreate($where, $agregar);
                }
            } else { // Si existe ubicacion
                if (trim($data['TCASILLERO']) != $ubi->TCASILLERO) {
                    // dd("Si existe ubicacion");
                    $ubi = Locker::updateOrCreate($where, $agregar);
                    // $ubi = Locker::where('TCODALM', '01')->where('TCODART', $model->ACODIGO)->update(['TCASILLERO'=> trim($data['TCASILLERO'])]);
                }
            }
        }

        $model->save();
        return redirect()->route('products.show', ['product' => $id]);
        // return redirect()->route('products.index');

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
        $models =  Product::with('stocks', 'price')->has('price')->has('stocks')->where('ACODIGO','like',"%$term%")->orWhere('ADESCRI','like',"%$term%")->get();
        $result=[];
        foreach ($models as $model) {
            if (!is_null($model->stocks) and !is_null($model->price) ) {
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

    public function apiGetProductos($term)
    {
        $models =  Product::with('stocks', 'price', 'lockers')->where('ACODIGO','like',"%$term%")->orwhere('ACODIGO2','like',"%$term%")->orWhere('ADESCRI','like',"%$term%")->orderBy('ACODIGO')->get();
        return response()->json($models);
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

    public function price_list()
    {
        $pdf = new PriceList();
        $pdf->_titulo=utf8_decode("LISTA DE PRECIOS MIRALDI");
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        // encabezado($fpdf, 'LISTA DE PRECIOS MIRALDI');
        // $models = Product::where('AESTADO', 'V')->with('stock', 'price')->has('price')->has('stock')->get();
        $models = \DB::connection('sqlsrv')->table('MAEART')
            ->join('LISTA_PRECIOS', 'MAEART.ACODIGO', '=', 'LISTA_PRECIOS.COD_ARTI')
            ->join('STKART', 'LISTA_PRECIOS.COD_ARTI', '=', 'STKART.STCODIGO')
            ->where('MAEART.AESTADO', 'V')
            // ->where('STKART.STSKDIS', '>', 0)
            ->select('MAEART.ACODIGO', 'MAEART.ADESCRI', 'MAEART.AUNIDAD', 'LISTA_PRECIOS.PRE_ACT', 'STKART.STSKDIS', 'MAEART.APESO')
            ->distinct()
            ->get();
        $pdf->PintaDetalle($models);
        
        $pdf->Output('I', 'lista_de_precios.pdf');
    }

    public function update_prices2()
    {
        dd("Actualizacion de precios deshabilitada");
        $fecha = request()->input('fecha');
        $prices = \DB::connection('mysql_old')->select("select CodInterno, ValorCompra, GastosAdmin, Utilidad, ValorVenta from stocks where Estado!=0 and (Fecha1 >= ? and Fecha2 >= ?)", [$fecha, $fecha]);
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

                    $p_l = Price::updateOrCreate($where, $agregar);
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

    public function movimientos($codigo)
    {
        $fechaLimite = date('Y-m-d 00:00:00', strtotime('-15 days'));
        $resultados['in_picking'] = 0;
        $resultados['stock'] = 0;
        $in_picking = PickingDetail::where('codigo', $codigo)
                                   ->whereNull('invoiced_at')
                                   ->where('created_at', '>=', $fechaLimite)
                                   ->groupBy('codigo')
                                   ->selectRaw('codigo, SUM(quantity) as total_quantity')
                                   ->first();

        $stock = Stock::where('STALMA', 1)->where('STCODIGO', $codigo)->first();
        $product = Product::where('ACODIGO', $codigo)->first();
        $resultados['product'] = $product;
        if (!is_null($stock)) {
            $resultados['stock'] = round($stock->STSKDIS, 2);
        }
        if (!is_null($in_picking)) {
            $resultados['in_picking'] = round($in_picking->total_quantity, 2);
        }
        // Consulta para obtener movimientos de productos (facturas y picking)
        $resultados['movimientos'] = PickingDetail::where('codigo', $codigo)->with('picking', 'order', 'user')->orderBy('created_at', 'desc')->get();

        // Devolver los resultados al cliente (por ejemplo, en formato JSON)
        return response()->json($resultados);

    }

    // public function rotacion(Request $request)
    // {
    //     // === RANGO DE FECHAS ===
    //     $fechaInicio = $request->input('desde')
    //         ? date('Y-d-m 00:00:00', strtotime($request->input('desde')))
    //         : date('Y-d-m 00:00:00', strtotime('-90 days'));

    //     $fechaFin = $request->input('hasta')
    //         ? date('Y-d-m 23:59:59', strtotime($request->input('hasta')))
    //         : date('Y-d-m 23:59:59');

    //     // === FORMATO PARA HTML INPUTS (Y-m-d) ===
    //     $fechaInicioInput = $request->input('desde')
    //         ? date('Y-m-d', strtotime($request->input('desde')))
    //         : date('Y-m-d', strtotime('-90 days'));

    //     $fechaFinInput = $request->input('hasta')
    //         ? date('Y-m-d', strtotime($request->input('hasta')))
    //         : date('Y-m-d');

    //     // === FORMATO CORRECTO SOLO PARA CALCULAR DÍAS (Y-m-d) ===
    //     $fechaInicioCalculo = $request->input('desde')
    //         ? date('Y-m-d', strtotime($request->input('desde')))
    //         : date('Y-m-d', strtotime('-90 days'));

    //     $fechaFinCalculo = $request->input('hasta')
    //         ? date('Y-m-d', strtotime($request->input('hasta')))
    //         : date('Y-m-d');

    //     // === CALCULAR CANTIDAD DE DÍAS PARA PROMEDIO ===
    //     $dias = (int) round((strtotime($fechaFinCalculo) - strtotime($fechaInicioCalculo)) / 86400);
    //     if ($dias <= 0) {
    //         $dias = 1;
    //     }

    //     // === CONSULTA SQL OPTIMIZADA ===
    //     $sql = "
    //         SELECT 
    //             A.ACODIGO AS Codigo,
    //             A.ADESCRI AS Descripcion,
    //             A.AUNIDAD AS Unidad,
    //             SUM(D.DFCANTID) AS Cant_Ven,
    //             CAST(SUM(D.DFCANTID) / NULLIF(? , 0) * 30 AS DECIMAL(18,2)) AS Prom_Mes,
    //             ISNULL(S01.STSKDIS, 0) AS Stock_01,
    //             ISNULL(S03.STSKDIS, 0) AS Stock_03,

    //             -- Moneda: si no hay compra nacional pero sí importación, usar 'ME'
    //             CASE 
    //                 WHEN C.CCCODMON IS NULL AND IMP.CDESPROVE IS NOT NULL THEN 'ME'
    //                 ELSE C.CCCODMON 
    //             END AS Moneda,

    //             -- Costo, cantidad, fecha y proveedor según fuente disponible
    //             C.DCPREC_COM AS Costo,
    //             C.DCCANTID AS Cant_Comp,

    //             CASE 
    //                 WHEN C.CCFECDOC IS NOT NULL THEN C.CCFECDOC
    //                 ELSE IMP.FEMISION
    //             END AS Fec_Compra,

    //             ISNULL(
    //                 CASE 
    //                     WHEN C.CCCODPRO IS NOT NULL THEN P.PRVCNOMBRE
    //                     ELSE IMP.CDESPROVE
    //                 END, 
    //                 C.CCCODPRO
    //             ) AS Proveedor,

    //             CASE 
    //                 WHEN C.CCCODPRO IS NULL AND IMP.CDESPROVE IS NOT NULL THEN 1
    //                 ELSE 0
    //             END AS EsImportacion

    //         FROM (
    //             SELECT DISTINCT D.DFCODIGO
    //             FROM FACDET D
    //             INNER JOIN FACCAB F ON F.CFTD = D.DFTD 
    //                 AND F.CFNUMSER = D.DFNUMSER 
    //                 AND F.CFNUMDOC = D.DFNUMDOC
    //             WHERE F.CFTD IN ('FT','BV')
    //               AND F.CFFECDOC BETWEEN ? AND ?
    //               AND D.DFCODIGO IS NOT NULL
    //         ) AS V

    //         INNER JOIN MAEART A ON A.ACODIGO = V.DFCODIGO
    //         LEFT JOIN FACDET D ON A.ACODIGO = D.DFCODIGO
    //         LEFT JOIN FACCAB F ON F.CFTD = D.DFTD 
    //             AND F.CFNUMSER = D.DFNUMSER 
    //             AND F.CFNUMDOC = D.DFNUMDOC
    //         LEFT JOIN STKART S01 ON S01.STCODIGO = A.ACODIGO AND S01.STALMA = '01'
    //         LEFT JOIN STKART S03 ON S03.STCODIGO = A.ACODIGO AND S03.STALMA = '03'

    //         -- Última compra nacional
    //         OUTER APPLY (
    //             SELECT TOP 1 
    //                 CD.DCPREC_COM, CD.DCCANTID, CB.CCFECDOC, CB.CCCODPRO, CB.CCCODMON
    //             FROM COMDET CD
    //             INNER JOIN COMCAB CB ON CB.ID_COMCAB = CD.ID_COMCAB
    //             WHERE CD.DCCODIGO = A.ACODIGO 
    //               AND CB.CCFECDOC IS NOT NULL
    //             ORDER BY CB.CCFECDOC DESC
    //         ) AS C

    //         LEFT JOIN MAEPROV P ON P.PRVCCODIGO = C.CCCODPRO

    //         -- Última importación (si existe)
    //         OUTER APPLY (
    //             SELECT TOP 1 
    //                 I.FEMISION, I.CDESPROVE
    //             FROM IMPORD D2
    //             INNER JOIN IMPORC I ON I.CNUMERO = D2.CNUMERO
    //             WHERE D2.CCODARTIC = A.ACODIGO
    //             ORDER BY I.FEMISION DESC
    //         ) AS IMP

    //         GROUP BY 
    //             A.ACODIGO, A.ADESCRI, A.AUNIDAD,
    //             S01.STSKDIS, S03.STSKDIS,
    //             C.CCCODMON, C.DCPREC_COM, C.DCCANTID, 
    //             C.CCFECDOC, C.CCCODPRO, P.PRVCNOMBRE, 
    //             IMP.CDESPROVE, IMP.FEMISION
    //         ORDER BY Cant_Ven DESC;
    //     ";

    //     // === EJECUTAR CONSULTA ===
    //     $data = \DB::connection('sqlsrv')->select($sql, [
    //         $dias,          // 1° parámetro: número de días para promedio
    //         $fechaInicio,   // 2° parámetro: fecha inicio con formato Y-d-m
    //         $fechaFin       // 3° parámetro: fecha fin con formato Y-d-m
    //     ]);

    //     // === RETORNAR VISTA ===
    //     return view('products.rotacion', compact('data', 'fechaInicioInput', 'fechaFinInput', 'fechaInicio', 'fechaFin', 'dias'));
    // }

    public function rotacion(Request $request)
    {
        // === RANGO DE FECHAS ===
        $fechaInicio = $request->input('desde')
            ? date('Y-d-m 00:00:00', strtotime($request->input('desde')))
            : date('Y-d-m 00:00:00', strtotime('-89 days'));

        $fechaFin = $request->input('hasta')
            ? date('Y-d-m 23:59:59', strtotime($request->input('hasta')))
            : date('Y-d-m 23:59:59');

        // === FORMATO PARA HTML INPUTS (Y-m-d) ===
        $fechaInicioInput = $request->input('desde')
            ? date('Y-m-d', strtotime($request->input('desde')))
            : date('Y-m-d', strtotime('-89 days'));

        $fechaFinInput = $request->input('hasta')
            ? date('Y-m-d', strtotime($request->input('hasta')))
            : date('Y-m-d');

        // === FORMATO CORRECTO SOLO PARA CALCULAR DÍAS (Y-m-d) ===
        $fechaInicioCalculo = $request->input('desde')
            ? date('Y-m-d', strtotime($request->input('desde')))
            : date('Y-m-d', strtotime('-89 days'));

        $fechaFinCalculo = $request->input('hasta')
            ? date('Y-m-d', strtotime($request->input('hasta')))
            : date('Y-m-d');

        // === CALCULAR CANTIDAD DE DÍAS PARA PROMEDIO ===
        $dias = (int) round((strtotime($fechaFinCalculo) - strtotime($fechaInicioCalculo)) / 86400) + 1;
        if ($dias <= 0) {
            $dias = 1;
        }

        // === CONSULTA SQL OPTIMIZADA ===
         $sql = "
        ;WITH VentasRango AS (
            SELECT 
                D.DFCODIGO,
                SUM(D.DFCANTID) AS Cant_Ven
            FROM FACDET D WITH (NOLOCK)
            INNER JOIN FACCAB F WITH (NOLOCK)
                ON F.CFTD = D.DFTD 
                AND F.CFNUMSER = D.DFNUMSER 
                AND F.CFNUMDOC = D.DFNUMDOC
            WHERE 
                F.CFTD IN ('FT','BV')
                AND F.CFFECDOC BETWEEN ? AND ?
                AND D.DFCODIGO IS NOT NULL
            GROUP BY D.DFCODIGO
        )
        SELECT 
            A.ACODIGO AS Codigo,
            A.ADESCRI AS Descripcion,
            A.AUNIDAD AS Unidad,

            ISNULL(V.Cant_Ven, 0) AS Cant_Ven,
            CAST(ISNULL(V.Cant_Ven, 0) / NULLIF(? , 0) * 30 AS DECIMAL(18,2)) AS Prom_Mes,

            ISNULL(S01.STSKDIS, 0) AS Stock_01,
            ISNULL(S03.STSKDIS, 0) AS Stock_03,

            -- Moneda
            CASE 
                WHEN (C.CCFECDOC IS NULL OR IMP.FEMISION > C.CCFECDOC) THEN 'ME'
                ELSE C.CCCODMON 
            END AS Moneda,

            -- Costo (usa el de importación si es más reciente)
            CASE 
                WHEN (C.CCFECDOC IS NULL OR IMP.FEMISION > C.CCFECDOC) THEN IMP.NPREUNITA
                ELSE C.DCPREC_COM
            END AS Costo,

            -- Cantidad (usa la de importación si es más reciente)
            CASE 
                WHEN (C.CCFECDOC IS NULL OR IMP.FEMISION > C.CCFECDOC) THEN IMP.NCANTIDAD
                ELSE C.DCCANTID
            END AS Cant_Comp,

            -- Fecha más reciente (entre compra nacional e importación)
            CASE 
                WHEN C.CCFECDOC IS NULL AND IMP.FEMISION IS NULL THEN NULL
                WHEN C.CCFECDOC IS NULL THEN IMP.FEMISION
                WHEN IMP.FEMISION IS NULL THEN C.CCFECDOC
                WHEN IMP.FEMISION > C.CCFECDOC THEN IMP.FEMISION
                ELSE C.CCFECDOC
            END AS Fec_Compra,

            -- Proveedor (según la fecha más reciente)
            CASE 
                WHEN C.CCFECDOC IS NULL AND IMP.FEMISION IS NULL THEN NULL
                WHEN C.CCFECDOC IS NULL THEN IMP.CDESPROVE
                WHEN IMP.FEMISION IS NULL THEN P.PRVCNOMBRE
                WHEN IMP.FEMISION > C.CCFECDOC THEN IMP.CDESPROVE
                ELSE P.PRVCNOMBRE
            END AS Proveedor,

            -- Marca si la última compra fue importación
            CASE 
                WHEN (IMP.FEMISION IS NOT NULL AND (C.CCFECDOC IS NULL OR IMP.FEMISION > C.CCFECDOC)) THEN 1
                ELSE 0
            END AS EsImportacion

        FROM VentasRango V
        INNER JOIN MAEART A WITH (NOLOCK) ON A.ACODIGO = V.DFCODIGO
        LEFT JOIN STKART S01 WITH (NOLOCK) ON S01.STCODIGO = A.ACODIGO AND S01.STALMA = '01'
        LEFT JOIN STKART S03 WITH (NOLOCK) ON S03.STCODIGO = A.ACODIGO AND S03.STALMA = '03'

        -- Última compra nacional
        OUTER APPLY (
            SELECT TOP 1 
                CD.DCPREC_COM, CD.DCCANTID, CB.CCFECDOC, CB.CCCODPRO, CB.CCCODMON
            FROM COMDET CD WITH (NOLOCK)
            INNER JOIN COMCAB CB WITH (NOLOCK) ON CB.ID_COMCAB = CD.ID_COMCAB
            WHERE CD.DCCODIGO = A.ACODIGO
              AND CB.CCFECDOC >= DATEADD(MONTH, -36, GETDATE())
              AND CB.CCFECDOC IS NOT NULL
            ORDER BY CB.CCFECDOC DESC
        ) AS C

        LEFT JOIN MAEPROV P WITH (NOLOCK) ON P.PRVCCODIGO = C.CCCODPRO

        -- Última importación (usando campos reales NCANTIDAD / NPREUNITA)
        OUTER APPLY (
            SELECT TOP 1 
                I.FEMISION,
                I.CDESPROVE,
                D2.NCANTIDAD,
                D2.NPREUNITA
            FROM IMPORD D2 WITH (NOLOCK)
            INNER JOIN IMPORC I WITH (NOLOCK) ON I.CNUMERO = D2.CNUMERO
            WHERE D2.CCODARTIC = A.ACODIGO
              AND I.FEMISION >= DATEADD(MONTH, -36, GETDATE())
            ORDER BY I.FEMISION DESC
        ) AS IMP

        ORDER BY V.Cant_Ven DESC;
        ";

        // === EJECUTAR CONSULTA ===
        $data = \DB::connection('sqlsrv')->select($sql, [
            $fechaInicio,  // para CTE (rango desde)
            $fechaFin,     // para CTE (rango hasta)
            $dias          // para cálculo de promedio
        ]);

        // === RETORNAR VISTA ===
        return view('products.rotacion', compact('data', 'fechaInicioInput', 'fechaFinInput', 'fechaInicio', 'fechaFin', 'dias'));
    }

    // public function detalleCompras(Request $request)
    // {
    //     $codigo = $request->get('codigo');

    //     $compras = \DB::connection('sqlsrv')->select("
    //         SELECT TOP 20 
    //             CB.CCFECDOC AS Fecha,
    //             CASE 
    //                 WHEN CB.CCTD = 'FT' THEN CONCAT(CB.CCNUMSER, '-', CB.CCNUMDOC)
    //                 ELSE NULL
    //             END AS Factura,
    //             CD.DCCANTID AS Cantidad,
    //             CD.DCPREC_COM AS P_Unit,
    //             (CD.DCCANTID * CD.DCPREC_COM) AS P_Total,
    //             CB.CCCODMON AS Mnd,
    //             P.PRVCNOMBRE AS Proveedor
    //         FROM COMDET CD
    //         INNER JOIN COMCAB CB ON CB.ID_COMCAB = CD.ID_COMCAB
    //         LEFT JOIN MAEPROV P ON P.PRVCCODIGO = CB.CCCODPRO
    //         WHERE CD.DCCODIGO = ?
    //         ORDER BY CB.CCFECDOC DESC
    //     ", [$codigo]);

    //     return view('products.partials.compras_detalle', compact('compras'));
    // }

    public function detalleCompras(Request $request)
    {
        $codigo = $request->get('codigo');

        $sql = "
            SELECT TOP 20 
                CB.CCFECDOC AS Fecha,
                CASE 
                    WHEN CB.CCTD = 'FT' THEN CONCAT(CB.CCNUMSER, '-', CB.CCNUMDOC)
                    ELSE NULL
                END AS Factura,
                CD.DCCANTID AS Cantidad,
                CD.DCPREC_COM AS P_Unit,
                (CD.DCCANTID * CD.DCPREC_COM) AS P_Total,
                CB.CCCODMON AS Mnd,
                P.PRVCNOMBRE AS Proveedor,
                'NACIONAL' AS Tipo
            FROM COMDET CD
            INNER JOIN COMCAB CB ON CB.ID_COMCAB = CD.ID_COMCAB
            LEFT JOIN MAEPROV P ON P.PRVCCODIGO = CB.CCCODPRO
            WHERE CD.DCCODIGO = ?

            UNION ALL

            SELECT 
                I.FEMISION AS Fecha,
                I.CNUMERO AS Factura,
                D.NCANTIDAD AS Cantidad,
                D.NPREUNITA AS P_Unit,
                D.NTOTVENT AS P_Total,
                'ME' AS Mnd,                 -- 🔹 siempre ME para importaciones
                C.CDESPROVE AS Proveedor,
                'IMPORTACIÓN' AS Tipo
            FROM IMPORD D
            INNER JOIN IMPORC C ON C.CNUMERO = D.CNUMERO
            INNER JOIN IMPORC I ON I.CNUMERO = D.CNUMERO
            WHERE D.CCODARTIC = ?

            ORDER BY Fecha DESC
        ";

        $compras = \DB::connection('sqlsrv')->select($sql, [$codigo, $codigo]);

        return view('products.partials.compras_detalle', compact('compras'));
    }

    public function stockVenta($codigo)
    {
        // Fecha límite = últimos 15 días
        $fechaLimite = date('Y-d-m 00:00:00', strtotime('-15 days'));

        $row = \DB::connection('sqlsrv')->table('PEDDET')
            ->join('PEDCAB', 'PEDCAB.CFNUMPED', '=', 'PEDDET.DFNUMPED')
            ->leftJoin('STKART as stk01', function ($join) use ($codigo) {
                $join->on('PEDDET.DFCODIGO', '=', 'stk01.STCODIGO')
                     ->where('stk01.STALMA', '=', '01');
            })
            ->where('PEDDET.DFCODIGO', $codigo)
            ->where('PEDCAB.CFFECDOC', '>=', $fechaLimite)
            ->where('PEDCAB.CFCOTIZA', 'AUTORIZADO')
            ->select(
                \DB::raw('ISNULL(stk01.STSKDIS, 0) as stock_01'),
                \DB::raw('SUM(PEDDET.DFCANTID) as demanda')
            )
            ->groupBy('stk01.STSKDIS')
            ->first();

        // Si no hay registros, asignar valores iniciales
        $stock01  = $row->stock_01  ?? 0;
        $demanda  = $row->demanda   ?? 0;

        // stock_venta no puede ser menor a 0
        $stockVenta = max($stock01 - $demanda, 0);

        return response()->json([
            'stock_01'     => $stock01,
            'demanda'      => $demanda,
            'stock_venta'  => $stockVenta,
        ]);
    }

}
