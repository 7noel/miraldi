<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

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
        $models =  Product::has('stock')->has('price')->with('stock', 'price')->where('ACODIGO','like',"%$term%")->orWhere('ADESCRI','like',"%$term%")->get();
        $result=[];
        foreach ($models as $model) {
            if ($model->stock->STSKDIS > 0) {
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
        $result = Product::with('stock','price','family','lockers')->where('ACODIGO', $id)->first();
        return response()->json($result);
    } 
}
