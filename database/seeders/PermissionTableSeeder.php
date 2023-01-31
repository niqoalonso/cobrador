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

        Permission::create(['name' => 'Gestion Usuarios',           'descripcion' => 'Crear usuario, editar usuario, listar usuario, eliminar o descativar usuario.']); //1
        Permission::create(['name' => 'Gestion Roles & Permisos',   'descripcion' => 'Crear roles, editar roles, listar roles, eliminar roles.']); //2
        Permission::create(['name' => 'Gestion Locales & Areas',    'descripcion' => 'Crear areas y locales, editar areas y locales, listar areas y locales, eliminar o desactivar areas y locales.']); //3
        Permission::create(['name' => 'Gestion Representante',      'descripcion' => 'Crear repesentante, editar representante, listar representantes, eliminar o desactivar representante.']); //4
        Permission::create(['name' => 'Gestion Clientes',           'descripcion' => 'Crear clientes, editar clientes, listar clientes, eliminar o desactivar clientes.']); //5
        Permission::create(['name' => 'Gestion Arriendo',           'descripcion' => 'Ingresa arriendo, editar arriendo, listar arriendos, finalizar arriendo, otros.']); //6
        Permission::create(['name' => 'Ingresar Postura',           'descripcion' => 'Ingrese postura de los arriendos actuales.']); //7
        Permission::create(['name' => 'Listar Postura',             'descripcion' => 'Revise historial de postura por arriendo.']); //8
        Permission::create(['name' => 'Anular Postura',             'descripcion' => 'Anule posturas mal ingresadas.']); //9

        Permission::create(['name' => 'Gestion Abono',              'descripcion' => 'Gestiona los abonos a ingresar.']); //10
        Permission::create(['name' => 'Historial Abono',            'descripcion' => 'Revisa historial de abonos.']); //11
        Permission::create(['name' => 'Solicitud Anulacion Abono',  'descripcion' => 'Revisa solicitudes de anulación en abonos.']); //12

        Permission::create(['name' => 'Gestion Posturas',           'descripcion' => 'Gestiona las posturas a ingresar.']); //13
        Permission::create(['name' => 'Historial Posturas',         'descripcion' => 'Revisa historial de posturas.']); //14
        Permission::create(['name' => 'Solicitud Anulacion Postura','descripcion' => 'Revisa solicitudes de anulación en postura.']); //15

        Permission::create(['name' => 'Ingreso Rendicion Abono',    'descripcion' => 'Ingresa las rendiciones de abonos.']); //16
        Permission::create(['name' => 'Historial Rendicion Abono',  'descripcion' => 'Historial rendiciones de abonos.']); //17
        Permission::create(['name' => 'Ingreso Rendicion Postura',  'descripcion' => 'Ingresa las rendiciones de posturas.']); //18
        Permission::create(['name' => 'Historial Rendicion Postura','descripcion' => 'Historial rendiciones de posturas.']); //19
        

        Permission::create(['name' => 'Solicitud Rendicion Abono',  'descripcion' => 'Historial rendiciones de abonos.']); //20
        Permission::create(['name' => 'Solicitud Rendicion Postura',  'descripcion' => 'Historial rendiciones de abonos.']); //21

        $rol = Role::create(['name' => 'Administrador']);
        $rol->syncPermissions([1,2,3,4,5,6,7,8,9,11,12,14,15,17,19]);

        $rol1 = Role::create(['name' => 'Recaudador']);
        $rol1->syncPermissions([10,11,13,14,16,17,18,19]);

        $rol1 = Role::create(['name' => 'Tesorero']);
        $rol1->syncPermissions([10,11,12,13,14,15,16,17,18,19,20,21]);
    }
}
