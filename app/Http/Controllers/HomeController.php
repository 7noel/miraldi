<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Modules\Storage\MoveRepo;
use App\Modules\Finances\CompanyRepo;
use App\Modules\Finances\Company;
use App\Modules\Storage\Product;
use App\Modules\Storage\Stock;
use App\Modules\Storage\SubCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $companyRepo = new CompanyRepo;
        // session(['my_company' => $companyRepo->find(1)]);
        //dd(session('my_company'));
        return view('home');
    }
    public function beta()
    {
        /*
        $fam = [
            "AUTOMOTRIZ"=>1,
            "CERRAJERIA PARA MADERA Y VIDRIO"=>2,
            "ELECTRONICA"=>3,
            "GASFITERIA"=>4,
            "GENERICOS"=>5,
            "ILUMINACION Y ELECTRICIDAD"=>6,
            "INTERNO"=>7,
            "MAQUINARIAS, HERRAMIENTAS Y REPUESTOS"=>8,
            "MATERIALES Y ACABADOS DE CONSTRUCCION"=>9,
            "SEGURIDAD INDUSTRIAL Y PROTECCION PERSONAL"=>10,
        ];
        $uni = [
            "BLD" => 1,
            "BLS" => 1,
            "BLT" => 1,
            "BOT" => 1,
            "CJA" => 1,
            "CTO" => 4,
            "DEC" => 3,
            "GZA" => 5,
            "JGO" => 7,
            "KG" => 9,
            "KIT" => 7,
            "MLL" => 6,
            "MT" => 8,
            "PQT" => 1,
            "PRS" => 2,
            "PZA" => 1,
            "RLL" => 1,
            "SCO" => 1,
            "SET" => 7,
        ];
        $ps = \DB::connection('masaki')->select("select * from material where Estado != '0'");
        foreach ($ps as $key => $p) {
            // dd($p);
            $product = Product::updateOrCreate(['intern_code' => $p->CodInterno], [
                'intern_code'=> $p->CodInterno,
                'name' => $p->NomProduc,
                'description' => $p->DatosAdicio,
                'sub_category_id' => $fam[trim($p->Familia)],
                'unit_id' => $uni[trim($p->Unidad)],
                'currency_id' => 1,
                // 'brand_id' => $p->
                // 'country_id' => 1465,
                'last_purchase' => $p->ValorCompra,
                'admin_expense' => $p->GastosAdmin,
                'profit_margin' => $p->Utilidad,
                'value' => $p->ValorVenta,
                'use_set_value' => '1',
                // 'use_set_value' => $p->PrecioLista,
                'is_downloadable' => 1,
                'status' => $p->Estado,

            ]);
            Stock::create([
                'product_id'=>$product->id,
                'warehouse_id'=>1,
                'currency_id'=>$product->currency_id,
                'avarage_value'=>$product->last_purchase,
            ]);
            Stock::create([
                'product_id'=>$product->id,
                'warehouse_id'=>2,
                'currency_id'=>$product->currency_id,
                'avarage_value'=>$product->last_purchase,
            ]);
            Stock::create([
                'product_id'=>$product->id,
                'warehouse_id'=>3,
                'currency_id'=>$product->currency_id,
                'avarage_value'=>$product->last_purchase,
            ]);
        }
// $controller = app()->make('App\Http\Controllers\HomeController');
// app()->call([$controller, 'beta'], []);
        echo "Productos agregados \n";
        
        $cs = \DB::connection('masaki')->select("select * from provedor where Datos1 != ''");
        $i_f = 0;
        $i_n = 0;
        foreach ($cs as $key => $c) {
            Company::updateOrCreate(['doc' => ($c->RUC>0) ? $c->RUC : $c->DNI, 'id_type_id' => ($c->RUC>0) ? 1 : 2], [
                'company_name' => $c->NombreRaz,
                'brand_name' => $c->RazComercial,
                'name' => $c->Nombre,
                'paternal_surname' => $c->ApellidoPat,
                'maternal_surname' => $c->ApellidoMat,
                'id_type_id' => ($c->RUC>0) ? 1 : 2,
                'doc' => ($c->RUC>0) ? $c->RUC : $c->DNI,
                'address' => substr(trim($c->Direccion), 0, (-1)*strlen(trim($c->Distrito))),
                'ubigeo_id' => $c->Datos1,
                'country_id' => 1465,
                'phone' => trim($c->Telefonos.' '.$c->Telefono1),
                'mobile' => trim($c->Celular1),
                'email' => $c->Email,
                'contact' => $c->Contacto1,
                'is_provider' => '1',
            ]);

                $i_n++;
        }

        echo "Proveedores ya existian: $i_f, nuevos: $i_n \n";

        $cs = \DB::connection('masaki')->select("select * from clientes where Departam2 != ''");
        $i_f = 0;
        $i_n = 0;
        foreach ($cs as $key => $c) {
            Company::updateOrCreate(['doc' => ($c->RUC>0) ? $c->RUC : $c->DNI, 'id_type_id' => ($c->RUC>0) ? 1 : 2], [
                'company_name' => $c->NombreRaz,
                'name' => $c->Nombre,
                'paternal_surname' => $c->ApellidoPat,
                'maternal_surname' => $c->ApellidoMat,
                'id_type_id' => ($c->RUC>0) ? 1 : 2,
                'doc' => ($c->RUC>0) ? $c->RUC : $c->DNI,
                'address' => substr(trim($c->Direccion), 0, (-1)*strlen(trim($c->Distrito))),
                'ubigeo_id' => $c->Departam2,
                'country_id' => 1465,
                'phone' => trim($c->Telefonos.' '.$c->Telefono1),
                'mobile' => trim($c->Celular.' '.$c->Celular1),
                'email' => $c->Email,
                'contact' => $c->Contacto1,
                'is_provider' => '0',
            ]);

                $i_n++;
        }

        dd("Clientes ya existian: $i_f, nuevos: $i_n \n");

        $as = \DB::connection('masaki')->select("select * from clientes where RUC>10000000000");
        foreach ($as as $key => $a) {
            $url = "http://api.noelhh.com/sunat/ruc/".$a->RUC;
            $json = file_get_contents($url);
            $obj = json_decode($json);
            
        }
        dd($a[0]->NombreRaz);
        $a = collect($a);
        dd($a->first());

        dd($obj);

        // set_time_limit(0);
        // $excel = \Importer::make('Excel');
        // $excel->load('D:\php\miraldi\noel_files\materiales.xlsx');
        // echo "excel leido";
        // $collection = $excel->getCollection();
        // echo "en collection";
        // dd($collection);
// $controller = app()->make('App\Http\Controllers\HomeController');
// app()->call([$controller, 'beta'], []);
*/
        $cs = \DB::connection('masaki')->select("select * from clientes where CodCliente=2633");
        $i_f = 0;
        $i_n = 0;
        foreach ($cs as $key => $c) {
            $ad = substr(trim($c->Direccion), 0, (-1)*strlen(trim($c->Distrito)));
            // dd(utf8_decode($c->Direccion));
            Company::updateOrCreate(['doc' => ($c->RUC>0) ? $c->RUC : $c->DNI, 'id_type_id' => ($c->RUC>0) ? 1 : 2], [
                'company_name' => $c->NombreRaz,
                'name' => $c->Nombre,
                'paternal_surname' => $c->ApellidoPat,
                'maternal_surname' => $c->ApellidoMat,
                'id_type_id' => ($c->RUC>0) ? 1 : 2,
                'doc' => ($c->RUC>0) ? $c->RUC : $c->DNI,
                'address' => $ad,
                'country_id' => 1465,
                'phone' => trim($c->Telefonos.' '.$c->Telefono1),
                'mobile' => trim($c->Celular.' '.$c->Celular1),
                'email' => $c->Email,
                'contact' => $c->Contacto1,
                'is_provider' => '0',
            ]);

                $i_n++;
        }
        dd($cs);

        $i=0;
        $ts = \DB::connection('masaki')->select("select * from transpor where Codigo > 619");
        foreach ($ts as $key => $t) {
            if (is_null(Company::where('doc',$t->RUC)->where('id_type_id', 1)->first())) {
                $url = "http://api.noelhh.com/sunat/ruc/".$t->RUC;
                $json = file_get_contents($url);
                $obj = json_decode($json);
                if (isset($obj->ruc)) {
                    Company::updateOrCreate(['doc' => $t->RUC, 'id_type_id' => 1], [
                        'company_name' => $t->Nombre,
                        'name' => $t->Nombre,
                        'id_type_id' => 1,
                        'doc' => $t->RUC,
                        'address' => $obj->direccion,
                        'ubigeo_id' => $obj->ubigeo->id,
                        'country_id' => 1465,
                        'phone' => trim($t->Telefonos),
                        'mobile' => trim($t->Celular),
                        'contact' => $t->Contacto1,
                        'comment' => $t->Fax,
                        'is_shipper' => '1',
                    ]);
                }
            }
            
        }
    }
    public function beta2()
    {
        $model = new MoveRepo;
        $p=1;
        //dd($model);
        $data['id'] = 25;
        $data['document'] = 'FACTURA';
        $data['code_document'] = '01';
        $data['series'] = '01';
        $data['number'] = '4600';
        $data['type_op'] = 'OUT';
        $data['input'] = 10;
        $data['output'] = 0;
        $data['stock'] = 60;
        $data['stock_id'] = 1;
        $data['unit_id'] = 1;
        $data['value'] = 55;
        $data['change_value'] = true;
        // $data['avarage_value_before'] =
        // $data['avarage_value_after'] =
        $data['document_model'] = '';
        $data['document_id'] = 1;

        for ($i=0; $i < 1; $i++) {
            $data['number'] = $data['number'] + 1;
            $data['value'] = $data['value'] + ($i*10);
            if ($p) {
                if ($data['type_op'] == 'IN') {
                    $data['type_op'] = 'OUT';
                    $data['input'] = 0;
                    $data['output'] = 40 + ($i*10);
                    $data['change_value'] = false;
                } else {
                    $data['type_op'] = 'IN';
                    $data['output'] = 0;
                    $data['input'] = 40 + ($i*10);
                    $data['change_value'] = true;
                }
            }
            
            //$model->save($data);
            $model->save($data, $data['id']);
        }
        dd($model);
        return $model;
    }

    public function select_company()
    {
        $companyRepo = new CompanyRepo;
        $companies = $companyRepo->getListMyCompany();
        // dd(session('my_company'));
        return view('admin.select_company', compact('companies'));
    }
    public function change_company()
    {
        $id = \Request::only('company')['company'];
        $companyRepo = new CompanyRepo;
        $newCompany = $companyRepo->find($id);
        session(['my_company'=>$newCompany]);
        return redirect('/select_company');
        
    }
}
