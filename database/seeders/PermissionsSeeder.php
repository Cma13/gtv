<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

	    Role::create(['name' => 'Administrador']);
	    Role::create(['name' => 'Profesor']);
	    Role::create(['name' => 'Alumno']);
	    Role::create(['name' => 'Usuario sin verificar']);

    }
}