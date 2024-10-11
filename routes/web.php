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
Route::get('demo', function () {
    return view('demo');
});
Route::get('/', 'HomeController@index');
// Route::get('/', function ()
// {
// 	dd(OrderDetail::first());
// 	// dd(Product::where('ACODIGO', '10100021')->first()->stock);
// 	// dd(Product::orderBy('ACODIGO', 'asc')->first()->stock);
// });
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Auth::routes();
// Auth::routes(['verify' => true]);


Route::get('pdf_to_print/{id}', ['as' => 'pickings.pdf_to_print', 'uses' => 'PickingController@pdf_to_print']);
Route::get('listarProvincias/{departamento}', ['as' => 'ajaxprovincias', 'uses' => 'UbigeoController@ajaxProvincias']);
Route::get('listarDistritos/{departamento}/{provincia}', ['as' => 'ajaxdistritos','uses' => 'UbigeoController@ajaxDistritos']);
Route::get('api/companiesAutocomplete/', ['as' => 'companiesAutocomplete', 'uses' => 'CompanyController@ajaxAutocomplete']);
Route::get('api/shippersAutocomplete/', ['as' => 'shippersAutocomplete', 'uses' => 'ShipperController@ajaxAutocomplete']);
Route::get('api/products/autocompleteAjax', ['as' => 'productsAutocomplete','uses' => 'ProductController@ajaxAutocomplete']);
Route::get('get_picking/{qr}', ['as' => 'get_picking', 'uses' => 'OrderController@get_picking']);
Route::get('get_oc/{id}', ['as' => 'products.get_oc', 'uses' => 'ProductController@get_oc']);

Route::group(['middleware'=>['auth']], function(){
    Route::get('change_password', ['as' => 'change_password', 'uses' => 'UserController@changePassword']);
    Route::post('update_password', ['as'=>'update_password', 'uses'=>'UserController@updatePassword']);
});

Route::group(['middleware'=>['auth', 'permissions']], function(){
    Route::resource('products','ProductController');
    Route::resource('pickings','PickingController');
    Route::resource('orders','OrderController');
    Route::resource('companies','CompanyController');
    Route::resource('shippers','ShipperController');
    Route::resource('users','UserController');
    Route::get('orders/print/{id}', ['as' => 'orders.print', 'uses' => 'OrderController@print']);
    Route::get('orders/print_note/{id}', ['as' => 'orders.print_note', 'uses' => 'OrderController@print_note']);
    Route::get('orders/print_original/{id}', ['as' => 'orders.print_original', 'uses' => 'OrderController@print_original']);
    Route::get('products_search', ['as' => 'products.search', 'uses' => 'ProductController@search']);
    Route::get('get_product/{id}', ['as' => 'products.get_product', 'uses' => 'ProductController@get_search']);
    Route::get('picking/print/{id}', ['as' => 'pickings.print', 'uses' => 'PickingController@print']);
    Route::get('excel_codbars', ['as' => 'products.excel_codbars', 'uses' => 'ProductController@excel_codbars']);
    Route::post('excel_codbars_download', ['as' => 'products.excel_codbars_download', 'uses' => 'ProductController@excel_codbars_download']);
    Route::post('codbars_save', ['as' => 'products.codbars_save', 'uses' => 'ProductController@codbars_save']);
    Route::get('update_prices', function () {
        return view('products.update_prices');
    });
    Route::post('update_prices2', ['as' => 'products.update_prices2', 'uses' => 'ProductController@update_prices2']);
});