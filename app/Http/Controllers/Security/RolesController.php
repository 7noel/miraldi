<?php namespace App\Http\Controllers\Security;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modules\Security\RoleRepo;
use App\Modules\Security\PermissionGroupRepo;
use App\Modules\Security\PermissionRepo;

class RolesController extends Controller {

	protected $repo;
	protected $permissionRepo;
	protected $permissionGroupRepo;

	public function __construct(RoleRepo $repo, PermissionGroupRepo $permissionGroupRepo, PermissionRepo $permissionRepo) {
		$this->repo = $repo;
		$this->permissionRepo = $permissionRepo;
		$this->permissionGroupRepo = $permissionGroupRepo;
	}

	public function index()
	{
		$models = $this->repo->index('name', request()->get('name'));
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$groups = $this->permissionGroupRepo->all();
		$permissions = $this->permissionRepo->all();
		return view('partials.create',compact('permissions' ,'groups'));
	}

	public function store()
	{
		$this->repo->save(request()->all());
		return redirect()->route('roles.index');
	}

	public function show($id)
	{
		$model = $this->repo->findOrFail($id);
		$groups = $this->permissionGroupRepo->all();
		$permissions = $this->permissionRepo->all();
		return view('partials.show', compact('model' ,'permissions' ,'groups'));
	}

	public function edit($id)
	{
		$model = $this->repo->findOrFail($id);
		$groups = $this->permissionGroupRepo->all();
		$permissions = $this->permissionRepo->all();
		return view('partials.edit', compact('model' ,'permissions' ,'groups'));
	}

	public function update($id)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route('roles.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route('roles.index');
	}

}
