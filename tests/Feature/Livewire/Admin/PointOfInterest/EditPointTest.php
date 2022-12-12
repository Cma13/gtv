<?php

namespace Tests\Feature\Livewire\Admin\PointOfInterest;

use App\Http\Livewire\Admin\Point\EditPoint;
use App\Models\PointOfInterest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditPointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function TestPointCanBeUpdated()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        $place2 = $this->createPlace();

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 84)
            ->set('editForm.longitude', 74)
            ->set('editForm.place', $place2->id)
            ->call('update', $pointOfInterest);

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => 'Prueba',
            'description' => 'Descripción de prueba',
            'latitude' => 84,
            'longitude' => 74,
            'place_id' => $place2->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function TestNameIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        $place2 = $this->createPlace();

        Livewire::test(EditPoint::class)
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 84)
            ->set('editForm.longitude', 78)
            ->set('editForm.place', $place2->id)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.name' => 'required']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

        /** @test */
        public function TestDescriptionIsRequired()
        {
            $adminUser = $this->createAdmin();
            $place = $this->createPlace();
            $pointOfInterest = PointOfInterest::factory()->create([
                'place_id' => $place->id,
            ]);
    
            $this->assertDatabaseCount('point_of_interests', 1);
    
            $this->actingAs($adminUser);
    
            $place2 = $this->createPlace();
    
            Livewire::test(EditPoint::class)
                ->set('editForm.name', 'Prueba')
                ->set('editForm.latitude', 84)
                ->set('editForm.longitude', 78)
                ->set('editForm.place', $place2->id)
                ->call('update', $pointOfInterest)
                ->assertHasErrors(['editForm.description' => 'required']);;
    
            $this->assertDatabaseCount('point_of_interests', 1);
            $this->assertDatabaseHas('point_of_interests', [
                'id' => $pointOfInterest->id,
                'name' => $pointOfInterest->name,
                'description' => $pointOfInterest->description,
                'latitude' => $pointOfInterest->latitude,
                'longitude' => $pointOfInterest->longitude,
                'place_id' => $place->id,
                'creator' => $adminUser->id,
                'updater' => $adminUser->id,
            ]);
        }

    /** @test */
    public function TestLatitudeIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        $place2 = $this->createPlace();

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.longitude', 78)
            ->set('editForm.place', $place2->id)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.latitude' => 'required']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function TestLongitudeIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        $place2 = $this->createPlace();

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 84)
            ->set('editForm.place', $place2->id)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.longitude' => 'required']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function TestPlaceIsRequired()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 84)
            ->set('editForm.longitude', 78)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.place' => 'required']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function TestPlacesExist()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 84)
            ->set('editForm.longitude', 78)
            ->set('editForm.place', 10)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.place' => 'exists']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function TestLatitudeIsANumber()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        $place2 = $this->createPlace();

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 'aaaaaaaa')
            ->set('editForm.longitude', 78)
            ->set('editForm.place', $place2->id)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.latitude' => 'numeric']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function TestLongitudeIsANumber()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = PointOfInterest::factory()->create([
            'place_id' => $place->id,
        ]);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->actingAs($adminUser);

        $place2 = $this->createPlace();

        Livewire::test(EditPoint::class)
            ->set('editForm.name', 'Prueba')
            ->set('editForm.description', 'Descripción de prueba')
            ->set('editForm.latitude', 84)
            ->set('editForm.longitude', 'aaaaaaa')
            ->set('editForm.place', $place2->id)
            ->call('update', $pointOfInterest)
            ->assertHasErrors(['editForm.longitude' => 'numeric']);;

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'id' => $pointOfInterest->id,
            'name' => $pointOfInterest->name,
            'description' => $pointOfInterest->description,
            'latitude' => $pointOfInterest->latitude,
            'longitude' => $pointOfInterest->longitude,
            'place_id' => $place->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

	/** @test */
	public function TestLatitudeIsValid()
	{
		$adminUser = $this->createAdmin();
		$place = $this->createPlace();
		$pointOfInterest = PointOfInterest::factory()->create([
			'latitude' => 0,
		]);

		$this->assertDatabaseCount('point_of_interests', 1);

		$this->actingAs($adminUser);

		Livewire::test(EditPoint::class)
			->set('editForm.name', 'Test')
			->set('editForm.distance', '0')
			->set('editForm.latitude', '90.1')
			->set('editForm.longitude', '0')
			->set('editForm.place', $place->id)
			->call('update', $pointOfInterest)
			->assertHasErrors(['editForm.latitude' => 'max']);;

		$this->assertDatabaseCount('point_of_interests', 1);
		$this->assertDatabaseHas('point_of_interests', [
			'id' => $pointOfInterest->id,
			'latitude' => 0
		]);

		Livewire::test(EditPoint::class)
			->set('editForm.name', 'Test')
			->set('editForm.distance', '0')
			->set('editForm.latitude', '-90.1')
			->set('editForm.longitude', '0')
			->set('editForm.place', $place->id)
			->call('update', $pointOfInterest)
			->assertHasErrors(['editForm.latitude' => 'min']);;

		$this->assertDatabaseCount('point_of_interests', 1);
		$this->assertDatabaseHas('point_of_interests', [
			'id' => $pointOfInterest->id,
			'latitude' => 0
		]);
	}

	/** @test */
	public function TestLongitudeIsValid()
	{
		$adminUser = $this->createAdmin();
		$place = $this->createPlace();
		$pointOfInterest = PointOfInterest::factory()->create([
			'longitude' => 0,
		]);

		$this->assertDatabaseCount('point_of_interests', 1);

		$this->actingAs($adminUser);

		Livewire::test(EditPoint::class)
			->set('editForm.name', 'Test')
			->set('editForm.distance', '0')
			->set('editForm.latitude', '0')
			->set('editForm.longitude', '180.1')
			->set('editForm.place', $place->id)
			->call('update', $pointOfInterest)
			->assertHasErrors(['editForm.longitude' => 'max']);;

		$this->assertDatabaseCount('point_of_interests', 1);
		$this->assertDatabaseHas('point_of_interests', [
			'id' => $pointOfInterest->id,
			'longitude' => 0
		]);

		Livewire::test(EditPoint::class)
			->set('editForm.name', 'Test')
			->set('editForm.distance', '0')
			->set('editForm.latitude', '0')
			->set('editForm.longitude', '-180.1')
			->set('editForm.place', $place->id)
			->call('update', $pointOfInterest)
			->assertHasErrors(['editForm.longitude' => 'min']);;

		$this->assertDatabaseCount('point_of_interests', 1);
		$this->assertDatabaseHas('point_of_interests', [
			'id' => $pointOfInterest->id,
			'longitude' => 0
		]);
	}

}
