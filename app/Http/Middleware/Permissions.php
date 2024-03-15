<?php namespace App\Http\Middleware;

// use App\Modules\Finances\CompanyRepo;
use Closure;
use App\Modules\Finances\Company;

class Permissions {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$names = [
			2 => ['orders', 'companies', 'shippers', 'orders.print', 'orders.print_note'], // permisos para vendedor
			3 => ['pickings', 'products.search', 'products.get_product', 'pickings.print'], // permisos para almacen
		];
    
		if (\Auth::user()->role_id == 1) { // si es rol administrador ingresa a la ruta
			return $next($request);
		} else {
			$actPar = $request->route()->getAction();
			$action = $actPar['as']; // devuelve el nombre de la ruta
			if (in_array($action, $names[\Auth::user()->role_id])) { // verifica si la ruta a ingresar está dentro de las rutas del rol del usuario
				return $next($request);
			} else {
				$_action = explode('.', $action);
				$model = array_shift($_action);
				if (in_array($model, $names[\Auth::user()->role_id])) {
					return $next($request);
				}
			}
			return response(view('errors.access_denied'));
		}
	}

}
