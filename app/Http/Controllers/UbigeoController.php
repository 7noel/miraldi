<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ubigeo;

class UbigeoController extends Controller
{
    public function ajaxprovincias($departamento)
    {
        $provincias = Ubigeo::where('departamento','=',$departamento)->groupBy('provincia')->orderBy('provincia')->get();
        return response()->json($provincias);
    }
    public function ajaxdistritos($departamento,$provincia)
    {
        $distritos = Ubigeo::where('departamento','=',$departamento)->where('provincia','=',$provincia)->orderBy('distrito')->get();
        //$distritos = $distritos->groupBy('CODIGO');
        return response()->json($distritos);
    }
    public function ajaxdistritos2($departamento,$provincia)
    {
        $distritos = Ubigeo::where('provincia','=',$provincia)->get();
        return response()->json($distritos);
    }
    public function ajaxGetDataUbigeo($code)
    {
        return response()->json(Ubigeo::where('code', $code)->first());
    }
}
