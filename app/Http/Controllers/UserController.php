<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Administracion\Usuario\UsuarioRequest;

class UserController extends Controller
{

    public function index()
    {   
        $roles = Role::all();
        $users = User::where('estado_id', 1)->get();
        return view('pages.usuario.index', compact('roles', 'users'));
    }

    public function verificarUser($rut)
    {   
        $user = User::where('rut', $rut)->first();

        if($user){
            if($user->estado_id == 2){
                return response()->json(['codigoEstado' => 1, 'Mensaje' => '¿Desea activar usuario?', 'datos' => $user]);
            }else{
                return response()->json(['codigoEstado' => 0, 'Mensaje' => 'Usuario ya esta ingresado.']);
            }    
        }else{
            return response()->json(['codigoEstado' => 3]);
        }
        
    }

    public function create()
    {
        $users = User::where('estado_id', 1)->get();

        return response()->json($users);
    }

    public function store(UsuarioRequest $request)
    {   

        $user = User::create(['name'        => $request->nombres.' '.$request->apellidos,
                              'nombres'     => $request->nombres, 
                              'apellidos'   => $request->apellidos, 
                              'email'       =>$request->correo,
                              'rut'         => $request->rut,
                              'password'    => Hash::make("admin"),
                              'estado_id'   => 1]);

        $user->assignRole($request->rol);

        return response()->json(['mensaje' => 'Usuario creado exitosament.']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {   
        $user = User::find($id);
        $rolUser = $user->getRoleNames();
        $roles = Role::All();
        return response()->json(['user' => $user, 'roles' => $roles, 'rolUser' => $rolUser]);
    }

    public function update(UsuarioRequest $request, $id)
    {   
        $user = User::updateOrCreate(['id' => $id],['name'        => $request->nombres.' '.$request->apellidos,
                                                    'nombres'     => $request->nombres, 
                                                    'apellidos'   => $request->apellidos, 
                                                    'email'       =>$request->correo,
                                                    'rut'         => $request->rut]);
        
        $user->syncRoles($request->rol);

        return response()->json(['mensaje' => 'Usuario actualizado exitosamente.']);
    
    }

    public function destroy($id)
    {
        //
    }
}
