<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Photography\Photographies;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePhotographyTest extends TestCase
{
    /** @test */
    public function itCreatesAPhotography()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('photographies', 0);

        $file = UploadedFile::fake()->create('photography.png', 1, 'image/png');

        Livewire::test(Photographies::class)
            ->set('createForm.route', $file)
            ->set('createForm.pointOfInterestId', $pointOfInterest->id)
            ->call('save');

        $this->assertDatabaseCount('photographies', 1);

        $this->assertDatabaseHas('photographies', [
            'order' => 1,
            'point_of_interest_id' => $pointOfInterest->id,
            'creator' => $adminUser->id,
            'updater' => null,
        ]);
    }

    /** @test */
    public function itChecksThatTheRouteFieldIsRequiredWhenCreatingAPhotography()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('photographies', 0);

        $file = UploadedFile::fake()->create('photography.png', 1, 'image/png');

        Livewire::test(Photographies::class)
            ->set('createForm.pointOfInterestId', $pointOfInterest->id)
            ->call('save')
            ->assertHasErrors(['createForm.route' => 'image']);

        $this->assertDatabaseCount('photographies', 0);
    }

    /** @test */
    public function itChecksThatThePointOfInterestFieldIsRequiredWhenCreatingAPhotography()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('photographies', 0);

        $file = UploadedFile::fake()->create('photography.png', 1, 'image/png');

        Livewire::test(Photographies::class)
            ->set('createForm.route', $file)
            ->call('save')
            ->assertHasErrors(['createForm.pointOfInterestId' => 'required']);

        $this->assertDatabaseCount('photographies', 0);
    }

    /** @test */
    public function itChecksThatThePointOfInterestFieldIsAnIntegerdWhenCreatingAPhotography()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('photographies', 0);

        $file = UploadedFile::fake()->create('photography.png', 1, 'image/png');

        Livewire::test(Photographies::class)
            ->set('createForm.route', $file)
            ->set('createForm.pointOfInterestId', 'asd')
            ->call('save')
            ->assertHasErrors(['createForm.pointOfInterestId' => 'integer']);

        $this->assertDatabaseCount('photographies', 0);
    }
}
