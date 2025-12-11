<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
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


Route::get('actulizarDetalles', ['as' => 'actulizarDetalles', 'uses' => 'PickingController@actulizarDetalles']);
Route::get('pdf_to_print/{id}', ['as' => 'pickings.pdf_to_print', 'uses' => 'PickingController@pdf_to_print']);
Route::get('picking/print/{id}', ['as' => 'pickings.print', 'uses' => 'PickingController@print']);
Route::get('listarProvincias/{departamento}', ['as' => 'ajaxprovincias', 'uses' => 'UbigeoController@ajaxProvincias']);
Route::get('listarDistritos/{departamento}/{provincia}', ['as' => 'ajaxdistritos','uses' => 'UbigeoController@ajaxDistritos']);
Route::get('api/companiesAutocomplete/', ['as' => 'companiesAutocomplete', 'uses' => 'CompanyController@ajaxAutocomplete']);
Route::get('api/shippersAutocomplete/', ['as' => 'shippersAutocomplete', 'uses' => 'ShipperController@ajaxAutocomplete']);
Route::get('api/products/autocompleteAjax', ['as' => 'productsAutocomplete','uses' => 'ProductController@ajaxAutocomplete']);
Route::get('get_picking/{qr}', ['as' => 'get_picking', 'uses' => 'OrderController@get_picking']);
Route::get('get_oc/{id}', ['as' => 'products.get_oc', 'uses' => 'ProductController@get_oc']);
Route::get('activar_pedido/{id}', ['as' => 'orders.activar', 'uses' => 'OrderController@activar_pedido']);
Route::get('por_comprar', ['as' => 'por_comprar', 'uses' => 'OrderController@por_comprar']);
Route::get('movimientos/{codigo}', ['as' => 'movimientos', 'uses' => 'ProductController@movimientos']);
Route::get('apiGetProductos/{term}', ['as' => 'apiGetProductos', 'uses' => 'ProductController@apiGetProductos']);
Route::get('/stock-venta/{codigo}', ['as' => 'stock-venta', 'uses' => 'ProductController@stockVenta']);
Route::get('compras/detalle', ['as' => 'compras.detalle', 'uses' => 'ProductController@detalleCompras']);
Route::get('/get_guia/{id}', ['as' => 'guia.view', 'uses' => 'OrderController@get_guia']);
Route::get('/etiquetas/cargar-logo', ['as' => 'etiquetas.cargar-logo', 'uses' => 'OrderController@cargarLogo']);
Route::post('/etiquetas/imprimir', ['as' => 'etiquetas.imprimir', 'uses' => 'OrderController@imprimir']);

Route::get('ver-pdf', function () {
    $ruta = request('ruta');

    // Si no hay ruta, error
    if (!$ruta) {
        abort(400, 'Ruta no especificada');
    }

    // 🔹 Obtener el nombre del archivo a partir de la ruta (sin punto final)
    $fileName = pathinfo(rtrim($ruta, '.'), PATHINFO_BASENAME) . '.pdf';

    // URL local al servicio Flask
    $urlFlask = 'http://127.0.0.1:5000/pdf-local?ruta=' . urlencode($ruta);

    try {
        $response = Http::timeout(60)->get($urlFlask);

        if ($response->failed()) {
            abort(404, 'Archivo no encontrado o error en servidor local');
        }

        // Entregar el PDF directamente al navegador
        return Response::make($response->body(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
            'Access-Control-Allow-Origin' => '*',
            'X-Frame-Options' => 'ALLOWALL',              // 👈 permite embeber
            'Content-Security-Policy' => "frame-ancestors *", // 👈 permite iframes
            'Cross-Origin-Resource-Policy' => 'cross-origin',
        ]);

    } catch (Exception $e) {
        abort(500, 'Error al obtener el PDF: ' . $e->getMessage());
    }
})->name('ver-pdf');


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
    Route::get('excel_codbars', ['as' => 'products.excel_codbars', 'uses' => 'ProductController@excel_codbars']);
    Route::post('excel_codbars_download', ['as' => 'products.excel_codbars_download', 'uses' => 'ProductController@excel_codbars_download']);
    Route::post('codbars_save', ['as' => 'products.codbars_save', 'uses' => 'ProductController@codbars_save']);
    Route::get('price_list', ['as' => 'price_list', 'uses' => 'ProductController@price_list']);
    Route::get('update_prices', function () {
        return view('products.update_prices');
    });
    Route::post('update_prices2', ['as' => 'products.update_prices2', 'uses' => 'ProductController@update_prices2']);
    Route::get('get_invoices_by_order/{id}', ['as' => 'orders.get_invoices', 'uses' => 'OrderController@get_invoices']);
    Route::get('rotacion', ['as' => 'rotacion', 'uses' => 'ProductController@rotacion']);
});