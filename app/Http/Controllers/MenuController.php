<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Finances\CompanyRepo;

class MenuController extends Controller
{
    protected $repo;

    public function links()
    {
        //session(['my_company' => 100]);
        //$arrayLinks = [];
        $arrayLinks = $this->arrayLinks();

        // if (\Auth::user()->is_superuser == true) {
        //     return $arrayLinks;
        // }

        // $permissions = \Auth::user()->getMyPermissions()->pluck('action');
        // foreach ($arrayLinks as $k => $module) {
        //     foreach ($module as $key => $link) {
        //         if (!isset($link['route'])) {
        //             unset($arrayLinks[$k][$key]);
        //         } elseif (!$permissions->search($link['route'])) {
        //             unset($arrayLinks[$k][$key]);
        //         }
        //     }
        //     if (count($arrayLinks[$k]) == 0) {
        //         unset($arrayLinks[$k]);
        //     }
        // }

        return $arrayLinks;

    }
    
    private function arrayLinks()
    {
        $links = [
            'Config'=>[
                ['name' => 'Usuarios', 'route' => 'users.index'],
                // ['name' => 'Roles', 'route' => 'roles.index', 'div' => '1'],
                // ['name' => 'Grupos', 'route' => 'permission_groups.index'],
                // ['name' => 'Permisos', 'route' => 'permissions.index'],
            ],
            'Almacén'=>[
                ['name' => 'Picking', 'route' => 'pickings.index'],
                ['name' => 'Productos', 'route' => 'products.index'],
                ['name' => 'Código de barras', 'route' => 'products.excel_codbars'],
            ],
            'Ventas'=>[
                //['name' => 'Cotizaciones', 'route' => 'quotes.index'],
                ['name' => 'Pedidos', 'route' => 'orders.index'],
                ['name' => 'Clientes', 'route' => 'companies.index'],
                ['name' => 'Transportistas', 'route' => 'shippers.index'],
                ['name' => 'Lista de precios', 'route' => 'price_list'],
            ],
        ];
        return $links;
    }
}