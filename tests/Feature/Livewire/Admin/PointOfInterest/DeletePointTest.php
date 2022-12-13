<?php

namespace Tests\Feature\Livewire\Admin\PointOfInterest;

use App\Http\Livewire\Admin\Point\ShowPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeletePointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function TestPointIsDeleted()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('point_of_interests', 1);

        $this->assertDatabaseHas('point_of_interests', [
            'longitude' => $pointOfInterest->longitude,
            'latitude' => $pointOfInterest->latitude,
            'place_id' => $pointOfInterest->place_id,
        ]);

        Livewire::test(ShowPoint::class)
            ->call('delete', $pointOfInterest->id);

	    $this->assertSoftDeleted($pointOfInterest);
    }
}
