<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Photography\Photographies;
use App\Models\Photography;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePhotographyTest extends TestCase
{
    /** @test */
    public function itUpdatesAPhotography()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $pointOfInterestA = $this->createPointOfInterest($place->id);

        $photographyA = Photography::factory()->create([
            'point_of_interest_id' => $pointOfInterestA->id,
        ]);

        $this->assertDatabaseCount('photographies', 1);

        $this->assertDatabaseHas('photographies', [
            'id' => $photographyA->id,
            'point_of_interest_id' => $pointOfInterestA->id,
            'creator' => $adminUser->id,
            'updater' => null,
        ]);

        $this->actingAs($adminUser);

        $pointOfInterestB = $this->createPointOfInterest($place->id);

        Livewire::test(Photographies::class)
            ->set('editForm.pointOfInterestId', $pointOfInterestB->id)
            ->call('update', $photographyA);

        $this->assertDatabaseCount('photographies', 1);

        $this->assertDatabaseHas('photographies', [
            'id' => $photographyA->id,
            'point_of_interest_id' => $pointOfInterestB->id,
            'creator' => $adminUser->id,
            'updater' => $adminUser->id,
        ]);
    }

    /** @test */
    public function itChecksThatThePointOfInterestFieldIsRequiredWhenUpdatingAPhotography()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        $pointOfInterestA = $this->createPointOfInterest($place->id);

        $photographyA = Photography::factory()->create([
            'point_of_interest_id' => $pointOfInterestA->id,
        ]);

        $this->assertDatabaseCount('photographies', 1);

        $this->assertDatabaseHas('photographies', [
            'id' => $photographyA->id,
            'point_of_interest_id' => $pointOfInterestA->id,
            'creator' => $adminUser->id,
            'updater' => null,
        ]);

        $this->actingAs($adminUser);

        $pointOfInterestB = $this->createPointOfInterest($place->id);

        Livewire::test(Photographies::class)
            ->call('update', $photographyA)
            ->assertHasErrors(['editForm.pointOfInterestId' => 'required']);

        $this->assertDatabaseCount('photographies', 1);

        $this->assertDatabaseHas('photographies', [
            'id' => $photographyA->id,
            'point_of_interest_id' => $pointOfInterestA->id,
            'creator' => $adminUser->id,
            'updater' => null,
        ]);
    }
}
