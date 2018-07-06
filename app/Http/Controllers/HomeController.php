<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Modules\Storage\MoveRepo;

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
        return view('home');
    }

    public function beta()
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
}
