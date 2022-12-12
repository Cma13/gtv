<?php

namespace Tests\Browser\Map;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapTest extends DuskTestCase
{
	use DatabaseMigrations;

    public function testMapShowsMarkers()
    {
	    $admin = $this->createAdmin();
	    $point = $this->createPointOfInterestPlaceThematicAreas();

        $this->browse(function (Browser $browser) use ($admin, $point) {
            $browser->loginAs($admin)
	            ->visitRoute('map')
	            ->pause(500)
				->assertSourceHas('aria-label="' . $point->name .'"');
        });
    }

	public function testMapHideMarkers()
	{
		$admin = $this->createAdmin();
		$point = $this->createPointOfInterestPlaceThematicAreas();

		$this->browse(function (Browser $browser) use ($admin, $point) {
			$browser->loginAs($admin)
				->visitRoute('map')
				->pause(500)
				->assertSourceHas('aria-label="' . $point->name .'"')
				->click('@checkbox-' . $point->id)
				->pause(500)
				->assertSourceMissing('aria-label="' . $point->name .'"');
		});
	}

	public function testMapShowData()
	{
		$admin = $this->createAdmin();
		$point = $this->createPointOfInterestPlaceThematicAreas();

		$this->browse(function (Browser $browser) use ($admin, $point) {
			$browser->loginAs($admin)
				->visitRoute('map')
				->pause(500)
				->click('#map > div > div > div:nth-child(2) > div:nth-child(2) > div > div:nth-child(3) > div:nth-child(2)')
				->pause(500)
				->assertSeeIn('#map', 'Nombre: ' . $point->name);
		});
	}
}
