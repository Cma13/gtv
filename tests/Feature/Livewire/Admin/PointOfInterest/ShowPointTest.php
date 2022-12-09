<?php

namespace Tests\Feature\Livewire\Admin\PointOfInterest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowPointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function TestListPointsOfInterest()
    {
        $adminUser = $this->createAdmin();
        $place1 = $this->createPlace();
        $place2 = $this->createPlace();
        $pointOfInterest1 = $this->createPointOfInterest($place1->id);
        $pointOfInterest2 = $this->createPointOfInterest($place2->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 2);

        $this->get('points-of-interest')
            ->assertOk()
            ->assertSeeInOrder([
                $pointOfInterest2->name,
                $pointOfInterest1->name,
            ]);;

    }
}

