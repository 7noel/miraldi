<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Base\TableRepo;


class TableController extends Controller {

	protected $repo;
	protected $controller;
	protected $list;

	public function __construct(TableRepo $repo) {
		$this->repo = $repo;
		$uri = request()->server('REQUEST_URI');
        $uri = explode('?', $uri);
        $url = explode('/', $uri[0]);
        array_shift($url);
        $this->prefix = array_shift($url);
        $this->controller = array_shift($url);
		$array_types = ['sub_categories'=>'categories'];
		$this->list = [];
		if (isset($array_types[$this->controller])) {
        	$this->list = $this->repo->getListType($array_types[$this->controller]);
		}
	}

	public function index()
	{
		$models = $this->repo->index2('name', request()->get('name'), $this->controller);
		return view('partials.index',compact('models'));
	}

	public function create()
	{
		$list = $this->list;
		return view('partials.create', compact('list'));
	}

	public function store()
	{
		$this->repo->save(request()->all());
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function show($id)
	{
		$list = $this->list;
		return view('partials.show', compact('model', 'list'));
	}

	public function edit($id)
	{
		$list = $this->list;
		$model = $this->repo->findOrFail($id);
		return view('partials.edit', compact('model', 'list'));
	}

	public function update($id)
	{
		$this->repo->save(request()->all(), $id);
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}

	public function destroy($id)
	{
		$model = $this->repo->destroy($id);
		if (request()->ajax()) {	return $model; }
		return redirect()->route(explode('.', request()->route()->getName())[0].'.index');
	}


}
