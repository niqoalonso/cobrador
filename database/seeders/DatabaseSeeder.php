<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Area;
use App\Models\Local;
use App\Models\Representante;
use App\Models\Empresa;
use App\Models\Arriendo;
use App\Models\Factura;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        
        $this->call([
            PermissionTableSeeder::class,
        ]);

        $admin = User::create([
                    'rut'       =>  '19088963-7',
                    'name'      =>  "Nicolas Alonso",
                    'nombres'   =>  'Nicolas',
                    'apellidos' =>  'Alonso',
                    'email'     =>  'niqo.alonso@gmail.com',
                    'password'  =>  Hash::make("admin"),
                    'estado_id' =>  1,
                ]);
        $admin->assignRole(1);

        $admin1 = User::create([
            'rut'       =>  '11111111-1',
            'name'      =>  "Administrador Vega",
            'nombres'   =>  'Administrador',
            'apellidos' =>  'Vega',
            'email'     =>  'vegamodelo@correo.com',
            'password'  =>  Hash::make("admin"),
            'estado_id' =>  1,
        ]);

        $admin1->assignRole(1);

        $admin2 = User::create([
            'rut'       =>  '22222222-2',
            'name'      =>  "Cobrador Primero",
            'nombres'   =>  'Cobrador',
            'apellidos' =>  'Primero',
            'email'     =>  'cobrador1@correo.com',
            'password'  =>  Hash::make("admin"),
            'estado_id' =>  1,
        ]);

        $admin2->assignRole(2);

        $admin3 = User::create([
            'rut'       =>  '33333333-3',
            'name'      =>  "Tesorero VModelo",
            'nombres'   =>  'Tesorero',
            'apellidos' =>  'VModelo',
            'email'     =>  'tesorero@correo.com',
            'password'  =>  Hash::make("admin"),
            'estado_id' =>  1,
        ]);

        $admin3->assignRole(3);

        $admin4 = User::create([
            'rut'       =>  '88888888-8',
            'name'      =>  "Cobrador Segundo",
            'nombres'   =>  'Cobrador',
            'apellidos' =>  'Segundo',
            'email'     =>  'cobrador2@correo.com',
            'password'  =>  Hash::make("admin"),
            'estado_id' =>  1,
        ]);

        $admin4->assignRole(2);



        Area::create(['nombre' => 'Bandejon A','estado_id' => 1]); //1
        Area::create(['nombre' => 'Bandejon B','estado_id' => 1]); //2

        Local::create([ 'identificador' => 'Local 1A',
                        'direccion' => 'Pasaje 2',
                        'area_id' => 1,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 2A',
                        'direccion' => 'Pasaje 1',
                        'area_id' => 1,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 3A',
                        'direccion' => 'Pasaje 3',
                        'area_id' => 1,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 4A',
                        'direccion' => 'Pasaje 4',
                        'area_id' => 1,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 5A',
                        'direccion' => 'Pasaje 5',
                        'area_id' => 1,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 1B',
                        'direccion' => 'Pasaje 6',
                        'area_id' => 2,
                        'estado_id' => 4]);

                        
        Local::create([ 'identificador' => 'Local 2B',
                        'direccion' => 'Pasaje 7',
                        'area_id' => 2,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 3B',
                        'direccion' => 'Pasaje 8',
                        'area_id' => 2,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 4B',
                        'direccion' => 'Pasaje 9',
                        'area_id' => 2,
                        'estado_id' => 4]);

        Local::create([ 'identificador' => 'Local 5B',
                        'direccion' => 'Pasaje 10',
                        'area_id' => 2,
                        'estado_id' => 3]);

        Local::create([ 'identificador' => 'Local 6B',
                        'direccion' => 'Pasaje 11',
                        'area_id' => 2,
                        'estado_id' => 3]);

        Local::create([ 'identificador' => 'Local 7B',
                        'direccion' => 'Pasaje 10',
                        'area_id' => 2,
                        'estado_id' => 3]);

        Local::create([ 'identificador' => 'Local 8B',
                        'direccion' => 'Pasaje 11',
                        'area_id' => 2,
                        'estado_id' => 3]);

        Representante::create([
            'rut' => '11678781-4',
            'nombres' => 'Soledad',
            'apellidos' => 'Ojeda',
            'correo' => 'soledad@gmail.com',
            'celular' => '956453456',
            'estado_id' => 1,
        ]);

        Representante::create([
            'rut' => '18811129-7',
            'nombres' => 'Miguel',
            'apellidos' => 'Osses',
            'correo' => 'miguel@gmail.com',
            'celular' => '956453456',
            'estado_id' => 1,
        ]);

        Representante::create([
            'rut' => '7813606-5',
            'nombres' => 'Enrique',
            'apellidos' => 'Alonso',
            'correo' => 'enrique@gmail.com',
            'celular' => '956453456',
            'estado_id' => 1,
        ]);

        Representante::create([
            'rut' => '12700559-1',
            'nombres' => 'Michelle',
            'apellidos' => 'Olate',
            'correo' => 'michelle@gmail.com',
            'celular' => '956453456',
            'estado_id' => 1,
        ]);

        Empresa::create([
            'sku' => 'EMP123',
            'rut' => '77123123-3',
            'razon_social' => 'Verduleria Amanecer Spa.',
            'nombre_fantasia' => 'Verduleria Amanecer',
            'correo' => 'amanecer@gmail.com',
            'telefono' => '345345',
            'celular' => '3453453',
            'solicita_fac_email' => 0,
            'alias' => 'Tios Amanecer',
            'url_perfil' => null,
            'estado_id' => 1, 
            'representante_id' => 1,
        ]);

        $arriendo1 = Arriendo::create([
            'sku'               => '348934',
            'url_contrato'      => 'url',
            'valor_arriendo'    => '9500000',
            'fecha_inicio'      => '2022/06/20',
            'fecha_termino'     => '2024/06/20',
            'estado_id'         =>  6, 
            'empresa_id'        => 1,
        ]);

        $arriendo1->Local()->sync([1,3]);

        $arriendo2 = Arriendo::create([
            'sku'               => '77645',
            'url_contrato'      => 'url',
            'valor_arriendo'    => '789000',
            'fecha_inicio'      => '2022/06/20',
            'fecha_termino'     => '2024/06/20',
            'estado_id'         =>  6, 
            'empresa_id'        => 1,
        ]);

        $arriendo2->Local()->sync([2]);


        Empresa::create([
            'sku' => 'EMP145',
            'rut' => '73123123-0',
            'razon_social' => 'Fruteria Don Miguelon Spa.',
            'nombre_fantasia' => 'Miguelon Fruteria',
            'correo' => 'miguelon@gmail.com',
            'telefono' => '345345',
            'celular' => '3453453',
            'solicita_fac_email' => 0,
            'alias' => 'Miguelon Miguel',
            'url_perfil' => null,
            'estado_id' => 1, 
            'representante_id' => 1,
        ]);

        $arriendo3 = Arriendo::create([
            'sku'               => '42344',
            'url_contrato'      => 'url',
            'valor_arriendo'    => '1500000',
            'fecha_inicio'      => '2022/12/10',
            'fecha_termino'     => '2023/12/10',
            'estado_id'         =>  5, 
            'empresa_id'        =>  2,
        ]);

        $arriendo3->Local()->sync([4,5,6]);

        Empresa::create([
            'sku' => 'EMP156',
            'rut' => '92345345-8',
            'razon_social' => 'Mariscos Don Clara Ltda.',
            'nombre_fantasia' => 'Do単a Clarita',
            'correo' => 'clara@gmail.com',
            'telefono' => '345345',
            'celular' => '3453453',
            'solicita_fac_email' => 0,
            'alias' => 'Srta Clara',
            'url_perfil' => null,
            'estado_id' => 1, 
            'representante_id' => 1,
        ]);

        $arriendo4 = Arriendo::create([
            'sku'               => '348934',
            'url_contrato'      => 'url',
            'valor_arriendo'    => '250000',
            'fecha_inicio'      => '2022/01/20',
            'fecha_termino'     => '2022/10/20',
            'estado_id'         =>  7, 
            'empresa_id'        =>  3,
        ]);

        $arriendo4 = Arriendo::create([
            'sku'               => '348934',
            'url_contrato'      => 'url',
            'valor_arriendo'    => '250000',
            'fecha_inicio'      => '2023/01/20',
            'fecha_termino'     => '2024/01/20',
            'estado_id'         =>  6, 
            'empresa_id'        =>  3,
        ]);

        $arriendo4->Local()->sync([7]);

        Empresa::create([
            'sku' => 'EMP1556',
            'rut' => '96123456-5',
            'razon_social' => 'Importadora de Alimernos de Perros Ltda.',
            'nombre_fantasia' => 'Perro Chocolo',
            'correo' => 'clara@gmail.com',
            'telefono' => '345345',
            'celular' => '3453453',
            'solicita_fac_email' => 0,
            'alias' => 'Marcos Chocolo',
            'url_perfil' => null,
            'estado_id' => 1, 
            'representante_id' => 1,
        ]);

        $arriendo5 = Arriendo::create([
            'sku'               => '348934',
            'url_contrato'      => 'url',
            'valor_arriendo'    => '450000',
            'fecha_inicio'      => '2022/05/20',
            'fecha_termino'     => '2024/05/20',
            'estado_id'         =>  5, 
            'empresa_id'        =>  4,
        ]);

        $arriendo5->Local()->sync([8,9]);

       
        Factura::create([
            'monto_total'       => 9500000,
            'monto_pendiente'   => 9500000,
            'fecha_emision'     => '2022-11-20',
            'n_factura'         => '423443', 
            'arriendo_id'       => 1,
        ]);

        Factura::create([
            'monto_total'       => 1500000,
            'monto_pendiente'   => 1500000,
            'fecha_emision'     => '2022-12-15',
            'n_factura'         => '478643', 
            'arriendo_id'       => 3,
        ]);

        Factura::create([
            'monto_total'       => 250000,
            'monto_pendiente'   => 250000,
            'fecha_emision'     => '2022-12-15',
            'n_factura'         => '478643', 
            'arriendo_id'       => 4,
        ]);

        Factura::create([
            'monto_total'       => 350000,
            'monto_pendiente'   => 300000,
            'fecha_emision'     => '2022-12-15',
            'n_factura'         => '478643', 
            'arriendo_id'       => 1,
        ]);

        Factura::create([
            'monto_total'       => 780000,
            'monto_pendiente'   => 780000,
            'fecha_emision'     => '2022-11-20',
            'n_factura'         => '423443', 
            'arriendo_id'       => 2,
        ]);
                
    }
}
