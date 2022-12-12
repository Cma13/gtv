<?php

namespace Tests\Feature\Livewire\Admin\PointOfInterest;

use App\Http\Livewire\Admin\Point\CreatePoint;
use App\Models\PointOfInterest;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function TestPointIsCreated()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);


        Livewire::test(CreatePoint::class)
            ->set('createForm.name', 'Prueba')
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save');

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->assertDatabaseHas('point_of_interests', [
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => null,
        ]);
    }

    /** @test */
    public function TestNameIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save')
            ->assertHasErrors(['createForm.name' => 'required']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestLatitudeIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.longitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save')
            ->assertHasErrors(['createForm.latitude' => 'required']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestLongitudeIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.latitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save')
            ->assertHasErrors(['createForm.longitude' => 'required']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestPlaceIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', '15')
            ->call('save')
            ->assertHasErrors(['createForm.place' => 'required']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestPlacesExist()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', '15')
            ->set('createForm.place', '99999')
            ->call('save')
            ->assertHasErrors(['createForm.place' => 'exists']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestLatitudeIsANumber()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.latitude', 'aaaaaaaaaaa')
            ->set('createForm.longitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save')
            ->assertHasErrors(['createForm.latitude' => 'numeric']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestLongitudeIsANumber()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', 'aaaaaaaaa')
            ->set('createForm.place', $place->id)
            ->call('save')
            ->assertHasErrors(['createForm.longitude' => 'numeric']);

        $this->assertDatabaseCount('point_of_interests', 0);
    }

    /** @test */
    public function TestPointIsNotVerifiedIfCreatedByAlumn()
    {
        $studentUser = $this->createStudent();
        $place = $this->createPlace();
        $point = [
            'name' => 'Prueba',
            'latitude' => 10,
            'longitude' => 10,
        ];

        $this->actingAs($studentUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.name', $point['name'])
            ->set('createForm.latitude', $point['latitude'])
            ->set('createForm.longitude', $point['longitude'])
            ->set('createForm.place', $place->id)
            ->call('save');

        $this->assertDatabaseHas('point_of_interests', [
            'name' => $point['name'],
            'latitude' => $point['latitude'],
            'longitude' => $point['longitude'],
            'place_id' => $place->id,
            'verified' => false
        ]);
    }

    /** @test */
    public function TestPointIsVerifiedIfCreatedByTeacher()
    {
        $teacherUser = $this->createTeacher();
        $place = $this->createPlace();
        $point = [
            'name' => 'Prueba',
            'latitude' => 10,
            'longitude' => 10,
        ];

        $this->actingAs($teacherUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.name', $point['name'])
            ->set('createForm.latitude', $point['latitude'])
            ->set('createForm.longitude', $point['longitude'])
            ->set('createForm.place', $place->id)
            ->call('save');

        $this->assertDatabaseHas('point_of_interests', [
            'name' => $point['name'],
            'latitude' => $point['latitude'],
            'longitude' => $point['longitude'],
            'place_id' => $place->id,
            'verified' => true
        ]);
    }

    /** @test */
    public function TestPointIsVerifiedIfCreatedByAdmin()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $point = [
            'name' => 'Prueba',
            'latitude' => 10,
            'longitude' => 10,
        ];

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 0);

        Livewire::test(CreatePoint::class)
            ->set('createForm.name', $point['name'])
            ->set('createForm.latitude', $point['latitude'])
            ->set('createForm.longitude', $point['longitude'])
            ->set('createForm.place', $place->id)
            ->call('save');

        $this->assertDatabaseHas('point_of_interests', [
            'name' => $point['name'],
            'latitude' => $point['latitude'],
            'longitude' => $point['longitude'],
            'place_id' => $place->id,
            'verified' => true
        ]);
    }
}
