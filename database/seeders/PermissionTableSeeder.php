<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{

    public function run()
    {

        Permission::create(['name' => 'Gestion Usuarios',           'descripcion' => 'Crear usuario, editar usuario, listar usuario, eliminar o descativar usuario.']);
        Permission::create(['name' => 'Gestion Roles & Permisos',   'descripcion' => 'Crear roles, editar roles, listar roles, eliminar roles.']);
        Permission::create(['name' => 'Gestion Locales & Areas',    'descripcion' => 'Crear areas y locales, editar areas y locales, listar areas y locales, eliminar o desactivar areas y locales.']);
        Permission::create(['name' => 'Gestion Representante',      'descripcion' => 'Crear repesentante, editar representante, listar representantes, eliminar o desactivar representante.']);
        Permission::create(['name' => 'Gestion Clientes',           'descripcion' => 'Crear clientes, editar clientes, listar clientes, eliminar o desactivar clientes.']);
        Permission::create(['name' => 'Gestion Arriendo',           'descripcion' => 'Ingresa arriendo, editar arriendo, listar arriendos, finalizar arriendo, otros.']);

        $rol = Role::create(['name' => 'Administrador']);

        $rol->syncPermissions([1,2,3,4]);

    }
}
