<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
    
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    protected $prefix;
    protected $controller;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // setlocale(LC_TIME, 'Spanish');
        // \Carbon::setUtf8(true);
        $uri = \Request::server('REQUEST_URI');
        $uri = explode('?', $uri);
        $url = explode('/', $uri[0]);
        array_shift($url);
        // $this->prefix = array_shift($url);
        $this->controller = array_shift($url) ?? 'orders';
        $_views = $this->views();
        $_routes = $this->routes();
        $_labels = $this->labels($this->controller);
        $_icons = $this->icons();
        View::share('views', $_views);
        View::share('routes', $_routes);
        View::share('labels', $_labels);
        View::share('icons', $_icons);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function views()
    {
        return [
            'scripts' => $this->controller. '.scripts',
            'table' => $this->controller. '.partials.table',
            'fields' => $this->controller. '.partials.fields',
            'edit' => $this->controller. '.edit',
            'delete' => $this->controller. '.delete',
            'filter' => $this->controller. '.partials.filter',
        ];
    }

    public function routes()
    {
        return [
            'index' => $this->controller. '.index',
            'create' => $this->controller. '.create',
            'store' => $this->controller. '.store',
            'edit' => $this->controller. '.edit',
            'update' => $this->controller. '.update',
            'delete' => $this->controller. '.destroy',
            'filter' => $this->controller. '.filter',
            'show' => $this->controller. '.show',
        ];
    }

    public function icons()
    {
        return [
            'poll' => '<i class="fas fa-poll"></i>',
            'store' => '<i class="fas fa-store"></i>',
            'view' => '<i class="fas fa-eye"></i>',
            'add' => '<i class="fas fa-plus"></i>',
            'edit' => '<i class="fas fa-pencil-alt"></i>',
            'remove' => '<i class="far fa-trash-alt"></i>',
            'email' => '<i class="far fa-envelope"></i>',
            'send' => '<i class="far fa-paper-plane"></i>',
            'printer' => '<i class="fas fa-print"></i>',
            'pdf' => '<i class="fas fa-file-pdf"></i>',
            'xml' => '<i class="far fa-file-code"></i>',
            'list' => '<i class="fas fa-list"></i>',
            'more' => '<i class="fas fa-ellipsis-v"></i>',
            'config' => '<i class="fas fa-cog"></i>',
            'credit-card' => '<i class="fas fa-credit-card"></i>',
            'pay' => '<i class="fab fa-cc-amazon-pay"></i>',
            'shopping' => '<i class="fas fa-shopping-cart"></i>',
            'file' => '<i class="fas fa-file-alt"></i>',
            'warning' => '<i class="fas fa-exclamation-triangle"></i>',
            'facebook' => '<i class="fab fa-facebook"></i>',
            'save' => '<i class="far fa-save"></i>',
            'search' => '<i class="fas fa-search"></i>',
            'shipping' => '<i class="fas fa-shipping-fast"></i>',
            'history' => '<i class="fas fa-history"></i>',
            'check' => '<i class="fas fa-check"></i>',
            'external' => '<i class="fas fa-external-link-square-alt"></i>',
            'invoice' => '<i class="fas fa-file-invoice"></i>',
            'close' => '<i class="fas fa-times"></i>',
            'car' => '<i class="fas fa-car"></i>',
            'refresh' => '<i class="fas fa-sync"></i>',
            'excel' => '<i class="far fa-file-excel"></i>',
        ];
    }

    public function labels($pre='exchanges')
    {
        // $pre = $this->controller;
        $arr = [
            'companies' => [
                'index'=>'Empresas',
                'index.create'=>'Crear Empresa',
                'create'=>'Registrar Empresa',
                'create.create'=>'Registrar Empresa',
                'show'=>'Vizualizando Empresa:',
                'edit'=>'Editar Empresa: ',
                'edit.update'=>'Actualizar Empresa',
                'edit.delete'=>'Eliminar Empresa',
            ],
            'shippers' => [
                'index'=>'Transportistas',
                'index.create'=>'Crear Transportista',
                'create'=>'Registrar Transportista',
                'create.create'=>'Registrar Transportista',
                'show'=>'Vizualizando Transportista:',
                'edit'=>'Editar Transportista: ',
                'edit.update'=>'Actualizar Transportista',
                'edit.delete'=>'Eliminar Transportista',
            ],
            'output_quotes' => [
                'index'=>'Cotizaciones',
                'index.create'=>'Crear Cotización',
                'create'=>'Nueva Cotización',
                'create.create'=>'Crear Cotización',
                'show'=>'Vizualizando Cotización:',
                'edit'=>'Editar Cotización: ',
                'edit.update'=>'Actualizar Cotización',
                'edit.delete'=>'Eliminar Cotización',
            ],
            'orders' => [
                'index'=>'Pedidos',
                'index.create'=>'Crear Pedido',
                'create'=>'Nuevo Pedido',
                'create.create'=>'Crear Pedido',
                'show'=>'Vizualizando Pedido:',
                'edit'=>'Editar Pedido: ',
                'edit.update'=>'Actualizar Pedido',
                'edit.delete'=>'Eliminar Pedido',
            ],
            'pickings' => [
                'index'=>'Pickings',
                'index.create'=>'Crear Picking',
                'create'=>'Nuevo Picking',
                'create.create'=>'Crear Picking',
                'show'=>'Vizualizando Picking:',
                'edit'=>'Editar Picking: ',
                'edit.update'=>'Actualizar Picking',
                'edit.delete'=>'Eliminar Picking',
            ],
            'users' => [
                'index'=>'Usuarios',
                'index.create'=>'Crear Usuario',
                'create'=>'Nuevo Usuario',
                'create.create'=>'Crear Usuario',
                'show'=>'Vizualizando Usuario:',
                'edit'=>'Editar Usuario: ',
                'edit.update'=>'Actualizar Usuario',
                'edit.delete'=>'Eliminar Usuario',
            ],
            'roles' => [
                'index'=>'Roles',
                'index.create'=>'Crear Rol',
                'create'=>'Nuevo Rol',
                'create.create'=>'Crear Rol',
                'show'=>'Vizualizando Rol:',
                'edit'=>'Editar Rol: ',
                'edit.update'=>'Actualizar Rol',
                'edit.delete'=>'Eliminar Rol',
            ],
            'permissions' => [
                'index'=>'Permisos',
                'index.create'=>'Crear Permiso',
                'create'=>'Nuevo Permiso',
                'create.create'=>'Crear Permiso',
                'show'=>'Vizualizando Permiso:',
                'edit'=>'Editar Permiso: ',
                'edit.update'=>'Actualizar Permiso',
                'edit.delete'=>'Eliminar Permiso',
            ],
            'permission_groups' => [
                'index'=>'Grupos',
                'index.create'=>'Crear Grupo',
                'create'=>'Nuevo Grupo',
                'create.create'=>'Crear Grupo',
                'show'=>'Vizualizando Grupo:',
                'edit'=>'Editar Grupo: ',
                'edit.update'=>'Actualizar Grupo',
                'edit.delete'=>'Eliminar Grupo',
            ],
        ];
        if (isset($arr[$pre])) {
            return $arr[$pre];
        }
        return [];
    }
}
