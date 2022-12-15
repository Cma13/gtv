<?php

namespace Tests\Feature\Livewire\Admin\Verify;

use App\Http\Livewire\Admin\Verify\DeletedVerify;
use App\Http\Livewire\Admin\Verify\ListVerify;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VerifyElementsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function TestElementNotVerifiedShowsInVerifyElements()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $point = $this->createPointNotVerified($place->id);

        $this->actingAs($adminUser);

        Livewire::test(ListVerify::class)
            ->assertSee($point->id)
            ->assertSee($point->name)
            ->assertSee(getDescripcionCorta(50, $point->description))
            ->assertSee($point->place->name);
    }

    /** @test */
    public function TestItVerifiesElement()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $point = $this->createPointNotVerified($place->id);

        $this->actingAs($adminUser);

        Livewire::test(ListVerify::class)
            ->call('verifyElement', $point->id, 'point')
            ->assertDontSee($point->name);

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'verified' => true
        ]);
    }

    /** @test */
    public function TestItSendsElementToTrash()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $point = $this->createPointNotVerified($place->id);

        $this->actingAs($adminUser);

        Livewire::test(ListVerify::class)
            ->call('moveToTrash', $point->id, 'point')
            ->assertDontSee($point->name);

        $this->assertDatabaseCount('point_of_interests', 1);
		$this->assertSoftDeleted($point);

        Livewire::test(DeletedVerify::class)
            ->assertSee($point->name);
    }

    /** @test */
    public function TestItRestoresElement()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $point = $this->createPointNotVerified($place->id);

        $this->actingAs($adminUser);

        Livewire::test(ListVerify::class)
            ->call('moveToTrash', $point->id, 'point')
            ->assertDontSee($point->name);

        Livewire::test(DeletedVerify::class)
            ->call('restoreElement', $point->id, 'point');

        $this->assertDatabaseCount('point_of_interests', 1);
        $this->assertDatabaseHas('point_of_interests', [
            'deleted_at' => null,
            'verified' => false
        ]);

        Livewire::test(ListVerify::class)
            ->assertSee($point->name);
    }

    /** @test */
    public function TestItDeletesElement()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $point = $this->createPointNotVerified($place->id);

        $this->actingAs($adminUser);

        Livewire::test(ListVerify::class)
            ->call('moveToTrash', $point->id, 'point')
            ->assertDontSee($point->name);

        $this->assertDatabaseCount('point_of_interests', 1);


        Livewire::test(DeletedVerify::class)
            ->call('hardDelete', [
                'elementId' => $point->id,
                'model' => 'point'
            ]);

        $this->assertDatabaseCount('point_of_interests', 0);
    }
}
