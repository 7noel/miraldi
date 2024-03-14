<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $search = request()->get('name');
        if ($search) {
            $models = User::name($search)->orderBy("name", 'ASC')->paginate();
        } else {
            $models = User::orderBy('name', 'DESC')->paginate();
        }

        return view('partials.index',compact('models'));
    }

    public function create()
    {
        // dd('en la funcion create');
        $roles = \DB::table('roles')->get()->pluck('name', 'id')->toArray();
        // dd($roles);
        $users = \DB::connection('starsoft2')->table('USUARIO_FAC')->where('CTEMPRESA', env('ST1_PRE_DATABASE', 'forge'))->pluck('CTUNOMUSU', 'CTUALIAS')->toArray();
        return view('partials.create', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $data = request()->all();
        $data['seller_code'] = \DB::connection('starsoft2')->table('USUARIO_FAC')->where('CTEMPRESA', env('ST1_PRE_DATABASE', 'forge'))->where('CTUALIAS',$data['user_code'])->first()->CTUVEND;
        User::updateOrCreate(['id' => 0], $data);
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $model = User::findOrFail($id);
        $roles = \DB::table('roles')->get()->pluck('name', 'id')->toArray();
        $users = \DB::connection('starsoft2')->table('USUARIO_FAC')->where('CTEMPRESA', env('ST1_PRE_DATABASE', 'forge'))->pluck('CTUNOMUSU', 'CTUALIAS')->toArray();
        return view('partials.edit', compact('model', 'roles', 'users'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->all();
        $data['seller_code'] = \DB::connection('starsoft2')->table('USUARIO_FAC')->where('CTEMPRESA', env('ST1_PRE_DATABASE', 'forge'))->where('CTUALIAS',$data['user_code'])->first()->CTUVEND;
        User::updateOrCreate(['id' => $id], $data);
        return \Redirect::route('users.index');
    }

    public function destroy($id)
    {
        $model = $this->repo->destroy($id);
        if (request()->ajax()) {    return $model; }
        return redirect()->route('users.index');
    }

    public function changePassword()
    {
        return view('auth.change_password');
    }
    public function updatePassword(Request $request)
    {
        $model = $this->repo->findOrFail(\Auth::user()->id);
        $model->fill($request->all());
        $model->save();
        return redirect()->to('/');
    }
    public function ajaxAutocomplete()
    {
        $term = \Input::get('term');
        $models = $this->repo->autocomplete($term);
        $result = [];
        foreach ($models as $model) {
            $result[]=[
                'value' => $model->email.' '.$model->name,
                'id' => $model->id,
                'label' => $model->email.' '.$model->name
            ];
        }
        return response()->json($result);
    }
}
