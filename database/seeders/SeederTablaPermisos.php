<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//Spatie -> seguridad
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            //asignando a la tabla roles
            'ver-rols',
            'crear-rols',
            'editar-rols',
            'borrar-rols',
            //asignando a la tabla cuarteles
            'ver-registers',
            'crear-registers',
            'editar-registers',
            'borrar-registers',
            //asignar a la tabla usuarios
            'ver-users',
            'crear-usuarios',
            'editar-usuarios',
            'borrar-usuarios',
        ];
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
