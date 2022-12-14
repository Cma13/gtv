<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('public')->deleteDirectory('user-avatars');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
			'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Administrador');

        $teacher = User::create([
            'name' => 'Teacher',
            'email' => 'teacher@mail.com',
	        'password' => Hash::make('password'),
        ]);
        $teacher->assignRole('Profesor');

        $student = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
	        'password' => Hash::make('password'),
        ]);
        $student->assignRole('Alumno');

	    $sinVerificar = User::create([
		    'name' => 'Student2',
		    'email' => 'student2@mail.com',
		    'password' => Hash::make('password'),
	    ]);
		$sinVerificar->assignRole('Usuario sin verificar');
    }
}
