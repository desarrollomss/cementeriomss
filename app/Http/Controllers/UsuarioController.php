<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

//modelos para los roles
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use Auth;

class UsuarioController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:VER-USUARIOS|CREAR-USUARIOS|EDITAR-USUARIOS|BORRAR-USUARIOS', ['only'=>['index']]);
        $this->middleware('permission:CREAR-USUARIOS', ['only'=>['create','store']]);
        $this->middleware('permission:EDITAR-USUARIOS', ['only'=>['edit','update']]);
        $this->middleware('permission:BORRAR-USUARIOS', ['only'=>['destroy']]);
    }

    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRol = $user->roles->pluck('name', 'name')->all();
        return view('usuarios.editar', compact('user','roles','userRol'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:password_confirmation',
            'roles' => 'required'
        ]);

        $input = $request->all();

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }
}
