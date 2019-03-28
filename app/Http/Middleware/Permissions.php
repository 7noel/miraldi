<?php namespace App\Http\Middleware;

use Closure;
use App\Modules\Security\Permission;
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
		$user = \Auth::user();
		if ($user->is_superuser) {
			return $next($request);
		} else {
			$actPar = $request->route()->getAction();
			$action = $actPar['as'];
			if (substr($action, -6) == '.store') { $action = str_replace('.store',	'.create', $action); }
			if (substr($action, -7) == '.update') { $action = str_replace('.update','.edit', $action); }
			if ($user->action_allowed($action, $user->id)) {
				return $next($request);
			}
			return view('errors.access_denied');
		}
	}

}
