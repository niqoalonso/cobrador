<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
                    'rut'       => '19088963-7',
                    'name'      => "Nicolas Alonso",
                    'nombres'   => 'Nicolas',
                    'apellidos' =>  'Alonso',
                    'email'     =>  'niqo.alonso@gmail.com',
                    'password'  =>  Hash::make("admin"),
                    'estado_id' =>  1,
                ]);
        
        $admin->assignRole(1);
        
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
