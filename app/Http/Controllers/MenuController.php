<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Security\UserRepo;

class MenuController extends Controller
{
    protected $repo;

    public function __construct(UserRepo $repo) {
        $this->repo = $repo;
    }
    public function links()
    {
        //$arrayLinks = [];
        $arrayLinks = $this->arrayLinks();

        if (\Auth::user()->is_superuser == true) {
            return $arrayLinks;
        }

        $permissions = $this->repo->allPermissions();

        foreach ($arrayLinks as $k => $module) {
            foreach ($module as $key => $link) {
                if (!isset($link['route'])) {
                    unset($arrayLinks[$k][$key]);
                } else if (!in_array($link['route'], $permissions)) {
                    unset($arrayLinks[$k][$key]);
                }
            }
            if (count($arrayLinks[$k]) == 0) {
                unset($arrayLinks[$k]);
            }
        }

        return $arrayLinks;

    }
    public function arrayLinks()
    {
        $links = [
            'Seguridad'=>[
                ['name' => 'Usuarios', 'route' => 'users.index' ],
                ['name' => 'Roles', 'route' => 'roles.index', 'div' => '1' ],
                ['name' => 'Grupos', 'route' => 'permission_groups.index' ],
                ['name' => 'Permisos', 'route' => 'permissions.index' ],
            ],
            'Almacén'=>[
                ['name' => 'Tickets de Ingreso y Salida', 'route' => 'tickets.index' ],
                // ['name' => 'Aprobar Notas de Pedido', 'url' => '#' ],
                ['name' => 'Productos', 'route' => 'products.index' ],
                ['name' => 'Almacenes', 'route' => 'warehouses.index' ],
                ['name' => 'Marcas', 'route' => 'brands.index', 'div' => '1' ],
                ['name' => 'Categorías', 'route' => 'categories.index'],
                ['name' => 'Sub Categorías', 'route' => 'sub_categories.index' ],
                ['name' => 'Tipos de Unidad', 'route' => 'unit_types.index' ],
                ['name' => 'Unidades', 'route' => 'units.index' ],
            ],
            'Recursos Humanos'=>[
                ['name' => 'Empleados', 'route' => 'employees.index' ],
                ['name' => 'Cargos', 'route' => 'jobs.index' ],
                // ['name' => 'Planilla', 'url' => '#' ],
                ['name' => 'Documentos', 'route' => 'id_types.index' ],
            ],
            'Finanzas'=>[
                ['name' => 'Empresas', 'route' => 'companies.index' ],
                // ['name' => 'Cuentas por Cobrar', 'url' => '#' ],
                // ['name' => 'Cuentas por Pagar', 'url' => '#' ],
                ['name' => 'Monedas', 'route' => 'currencies.index', 'div' => '1' ],
                ['name' => 'Tipo de Cambio', 'route' => 'exchanges.index' ],
                ['name' => 'Documentos', 'route' => 'document_types.index' ],
                ['name' => 'Control de Documentos', 'route' => 'document_controls.index' ],
                ['name' => 'Condiciones de Pago', 'route' => 'payment_conditions.index' ],
                ['name' => 'Medios de Pago', 'route' => 'payment_conditions.index' ],
            ],
            'Ventas'=>[
                ['name' => 'Cotizaciones', 'route' => 'orders.index' ],
                // ['name' => 'Facturación', 'route' => 'sales.index' ],
            ],
            'Logística'=>[
                // ['name' => 'Ordenes de Compra', 'url' => '#' ],
                ['name' => 'Compras', 'route' => 'purchases.index' ],
            ],
        ];
        return $links;
    }

}