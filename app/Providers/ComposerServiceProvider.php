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
        setlocale(LC_TIME, 'Spanish');
        \Carbon::setUtf8(true);
        $uri = \Request::server('REQUEST_URI');
        $uri = explode('?', $uri);
        $url = explode('/', $uri[0]);
        array_shift($url);
        $this->prefix = array_shift($url);
        $this->controller = array_shift($url);
        $_views = $this->views();
        $_routes = $this->routes();
        $_labels = $this->labels();
        View::share('views', $_views);
        View::share('routes', $_routes);
        View::share('labels', $_labels);
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
            'scripts' => $this->prefix . '.' . $this->controller. '.scripts',
            'table' => $this->prefix . '.' . $this->controller. '.partials.table',
            'fields' => $this->prefix . '.' . $this->controller. '.partials.fields',
            'edit' => $this->prefix . '.' . $this->controller. '.edit',
            'delete' => $this->prefix . '.' . $this->controller. '.delete',
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
        ];
    }

    public function labels()
    {
        return [
            'index' => 'options.' . $this->controller . '.index',
            'create' => 'options.' . $this->controller . '.create',
            'edit' => 'options.' . $this->controller . '.edit',
            'show' => 'options.' . $this->controller . '.show',
        ];
    }
}
