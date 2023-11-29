<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Ubigeo;

class CompanyController extends Controller
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
            $models = Company::name($search)->orderBy("DFECINS", 'ASC')->paginate();
        } else {
            $models = Company::orderBy('DFECINS', 'DESC')->paginate();
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
        $ubigeo = $this->listUbigeo();
        return view('partials.create', compact('ubigeo'));
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
        Company::updateOrCreate(['CCODCLI' => 0], $data);
        if (isset($data['last_page']) && $data['last_page'] != '') {
            return redirect()->to($data['last_page']);
        }
        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Company::findOrFail($id);
        $ubigeo = $this->listUbigeo($model->ubigeo_code);
        return view('partials.show', compact('model', 'ubigeo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Company::findOrFail($id);
        $ubigeo = $this->listUbigeo($model->UBIGEO);
        return view('partials.edit', compact('model', 'ubigeo'));
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
        $data = $this->prepareData2($data);
        // dd($data);
        Company::updateOrCreate(['CCODCLI' => $id], $data);
        if (isset($data['last_page']) && $data['last_page'] != '') {
            return redirect()->to($data['last_page']);
        }
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->repo->destroy($id);
        if (request()->ajax()) {    return $model; }
        return redirect()->route('companies.index');
    }


    public function ajaxAutocomplete()
    {
        $term = request()->get('term');
        $models =  Company::where('CNOMCLI','like',"%$term%")->orWhere('CCODCLI','like',"%$term%")->get();
        // dd($models);

        $result = $models->map(function ($model){
            return [
                'value' => $model->CNOMCLI,
                'id' => $model,
                'label' => config('options.client_doc.'.$model->CTIPO_DOCUMENTO).' '.$model->CCODCLI.' '.$model->CNOMCLI,
            ];
        });
        return response()->json($result);
    }

    public function listUbigeo($code='0')
    {
        $ubi=Ubigeo::firstWhere('code', $code);
        if (is_null($ubi)) {
            $ubigeo['value']['departamento'] = 'LIMA';
            $ubigeo['value']['provincia'] = 'LIMA';
            $ubigeo['value']['distrito'] = '';
            $ubigeo['departamento'] = $this->listdepartamentos();
            $ubigeo['provincia'] = $this->listprovincias();
            $ubigeo['distrito'] = $this->listdistritos();
        } else {
            $ubigeo['value']['departamento'] = $ubi->departamento;
            $ubigeo['value']['provincia'] = $ubi->provincia;
            $ubigeo['value']['distrito'] = $ubi->code;
            $ubigeo['departamento'] = $this->listdepartamentos();
            $ubigeo['provincia'] = $this->listprovincias($ubi->departamento);
            $ubigeo['distrito'] = $this->listdistritos($ubi->provincia);
        }
        $ubigeo['departamento'] = ['' => 'Seleccionar'] + $ubigeo['departamento'];
        $ubigeo['provincia'] = ['' => 'Seleccionar'] + $ubigeo['provincia'];
        $ubigeo['distrito'] = ['' => 'Seleccionar'] + $ubigeo['distrito'];
        return $ubigeo;
    }
    public function listdepartamentos()
    {
        return Ubigeo::select('departamento')->groupBy('departamento')->orderBy('departamento')->pluck('departamento','departamento')->toArray();
    }
    public function listprovincias($departamento='LIMA')
    {
        return Ubigeo::select('provincia')->where('provincia','NOT LIKE','%?%')->where('departamento','=',$departamento)->groupBy('provincia')->orderBy('provincia')->pluck('provincia','provincia')->toArray();
    }
    public function listdistritos($provincia='LIMA')
    {
        return Ubigeo::select('code','distrito')->where('distrito','NOT LIKE','%?%')->where('distrito','NOT LIKE','%?%')->where('provincia','=',$provincia)->orderBy('distrito')->pluck('distrito','code')->toArray();
    }
    public function prepareData($data)
    {
        if ($data['CTIPO_DOCUMENTO']=='6') {
            $data['CNUMRUC']=$data['CCODCLI'];
            $data['CDOCIDEN']='';
        } else {
            $data['CNUMRUC']='';
            $data['CDOCIDEN']=$data['CDOCIDEN'];
        }
        $data['TCL_CODIGO']='1';
        $data['CESTADO']='V';
        $data['DFECINS']=date('Y-d-m H:i:s');
        $data['CUSUARI']='';
        $data['DFECCRE']=date('Y-d-m H:i:s');
        $data['CVENDE']='';
        $data['MONCRE']='MN';
        
        return $data;
    }
    public function prepareData2($data)
    {
        if ($data['CTIPO_DOCUMENTO']=='6') {
            $data['CNUMRUC']=$data['CCODCLI'];
            $data['CDOCIDEN']='';
        } else {
            $data['CNUMRUC']='';
            $data['CDOCIDEN']=$data['CDOCIDEN'];
        }
        $data['CUSUARI'] = \Auth::user()->user_code;
        $data['CVENDE'] = \Auth::user()->seller_code;
        $data['DFECMOD'] = date('Y-d-m H:i:s');
        
        return $data;
    }
}
