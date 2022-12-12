<?php

namespace Tests;

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\ThematicArea;
use App\Models\User;
use App\Models\Video;
use App\Models\Visit;
use Spatie\Permission\Models\Role;

trait TestHelpers
{
    protected function createAdmin()
    {
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $unverifiedUser = Role::firstOrCreate(['name' => 'Usuario sin verificar']);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($adminRole);

        return $user;
    }

    protected function createStudent()
    {
        $studentRole = Role::firstOrCreate(['name' => 'Alumno']);
	    $unverifiedUser = Role::firstOrCreate(['name' => 'Usuario sin verificar']);

        $user = User::create([
            'name' => 'Alumno',
            'email' => 'alumno@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($studentRole);

        return $user;
    }

    protected function createTeacher()
    {
        $teacherRole = Role::firstOrCreate(['name' => 'Profesor']);
	    $unverifiedUser = Role::firstOrCreate(['name' => 'Usuario sin verificar']);

        $user = User::create([
            'name' => 'Profesor',
            'email' => 'profesor@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($teacherRole);

        return $user;
    }

	protected function createUnverifiedUser()
	{
		$unverifiedUser = Role::firstOrCreate(['name' => 'Usuario sin verificar']);

		$user = User::create([
			'name' => 'Usuario sin verificar',
			'email' => 'usuario@mail.com',
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		]);
		$user->assignRole($unverifiedUser);

		return $user;
	}

    protected function createPlace()
    {
        return Place::factory()->create();
    }

    protected function createPointOfInterest($placeId)
    {
        return PointOfInterest::factory()->create([
            'place_id' => $placeId,
        ]);
    }

    protected function createPointNotVerified($placeId)
    {
        return PointOfInterest::factory()->create([
            'place_id' => $placeId,
            'verified' => false,
        ]);
    }

    protected function createVisit($pointId){
        return Visit::factory()->create([
           'point_of_interest_id' => $pointId,
        ]);
    }

    protected function createThematicArea($pointOfInterestId)
    {
        $thematicArea = ThematicArea::factory()->create();

        $thematicArea->pointsOfInterest()->attach($pointOfInterestId);

        return $thematicArea;
    }

    protected function createVideo()
    {
        $video = Video::factory()->create();
        return $video;
    }

    protected function createPhotography()
    {
        return Photography::factory()->create();
    }

	protected function createPointOfInterestPlaceThematicAreas($options = [], $place = null, $thematicAreas = null)
	{
		if (!$place) {
			$place = Place::factory()->create();
		}

		$options = array_replace([
			'place_id' => $place->id,
		], $options);

		$pointOfInterest = PointOfInterest::factory()->create($options);

		if (!$thematicAreas) {
			$thematicAreas = ThematicArea::factory()->create();
			$thematicAreasId = $thematicAreas->id;
		} else {
			if (is_iterable($thematicAreas)) {
				foreach ($thematicAreas as $thematicArea) {
					$thematicAreasId[] = $thematicArea->id;
				}
			} else {
				$thematicAreasId = $thematicAreas->id;
			}
		}

		$pointOfInterest->thematicAreas()->attach($thematicAreasId);

		return $pointOfInterest;
	}
}
