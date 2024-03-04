<?php

use Illuminate\Support\Facades\Route;
use App\Product;
use App\Stock;
use App\Price;
use App\Order;
use App\OrderDetail;
use App\Seller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('houses', function () {
    return view('welcome');
});
Route::get('/', 'HomeController@index');
// Route::get('/', function ()
// {
// 	dd(OrderDetail::first());
// 	// dd(Product::where('ACODIGO', '10100021')->first()->stock);
// 	// dd(Product::orderBy('ACODIGO', 'asc')->first()->stock);
// });
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

// Auth::routes();
Auth::routes(['verify' => true]);


Route::get('listarProvincias/{departamento}', ['as' => 'ajaxprovincias', 'uses' => 'UbigeoController@ajaxProvincias']);
Route::get('listarDistritos/{departamento}/{provincia}', ['as' => 'ajaxdistritos','uses' => 'UbigeoController@ajaxDistritos']);
Route::get('api/companiesAutocomplete/', ['as' => 'companiesAutocomplete', 'uses' => 'CompanyController@ajaxAutocomplete']);
Route::get('api/products/autocompleteAjax', ['as' => 'productsAutocomplete','uses' => 'ProductController@ajaxAutocomplete']);
Route::get('get_picking/{qr}', ['as' => 'get_picking', 'uses' => 'OrderController@get_picking']);

Route::group(['middleware'=>['auth']], function(){
    Route::resource('orders','OrderController');
    Route::resource('companies','CompanyController');
    Route::resource('shippers','ShipperController');
    Route::resource('users','UserController');
    Route::get('orders/print/{id}', ['as' => 'print_order', 'uses' => 'OrderController@print']);
    Route::get('orders/print_note/{id}', ['as' => 'print_note', 'uses' => 'OrderController@print_note']);
    Route::get('picking', ['as' => 'picking', 'uses' => 'OrderController@picking']);
    Route::get('products_search', ['as' => 'products.search', 'uses' => 'ProductController@search']);
    Route::get('get_product/{id}', ['as' => 'products.get_product', 'uses' => 'ProductController@get_search']);
});