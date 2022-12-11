<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Administracion\Role\RoleRequest;

class GestionRolController extends Controller
{

    public function index()
    {   
        $permisos = Permission::all();
        $roles = Role::all();

        return view('pages.roles_permisos.index', compact('permisos', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $roles->load('permissions');
        return response()->json($roles);
    }

    public function store(RoleRequest $request)
    {   
        $role = Role::create(['name' => $request->nombre]);
        $role->givePermissionTo($request->permisos);
    
        return response()->json(['mensaje' => 'ROL creado exitosamente.']);
    }

    public function edit($id)
    {
        $rol = Role::find($id);
        $rol->load('permissions');

        return response()->json($rol);
    }

    public function update(RoleRequest $request, $id)
    {   
        $role = Role::updateOrCreate(['id' => $id],['name' => $request->nombre]);
        $role->syncPermissions($request->permisos);

        return response()->json(['mensaje' => 'Rol actualizado.']);
    }

    public function destroy($id)
    {   
        $rol = Role::find($id);
        $rol->delete();

        return response()->json(['mensaje' => 'ROL eliminado exitosamente.']);
    }

    public function verificarUsoROl($id)
    {
            $rol = Role::find($id);

            if(count($rol->users) == 0)
            {
                return response()->json(['codigoEstado' => '0', 'mensaje' => '¿Esta seguro que desea eliminar este ROL?']);
            }else{
                return response()->json(['codigoEstado' => '1', 'mensaje' => 'ROL esta en uso. Esta asignado a un usuario.']);
            }

            return response()->json(count($rol->users));
    }
}
