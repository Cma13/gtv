<?php

namespace Tests\Feature\Livewire\Admin\Map;

use App\Http\Livewire\Map;
use App\Models\Place;
use App\Models\ThematicArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MapTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function TestMapPlaceFilter()
	{
		$admin = $this->createAdmin();
		$place1 = Place::factory()->create([
			'name' => 'place1',
		]);
		$place2 = Place::factory()->create([
			'name' => 'place2',
		]);

		$point1 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'point1'
		], $place1);
		$point2 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'point2'
		], $place2);

		Livewire::actingAs($admin)
			->test(Map::class)
			->assertSee('point1')
			->assertSee('point2')
			->set('filters.place', $place1->id)
			->assertSee('point1')
			->assertDontSee('point2')
			->set('filters.place', $place2->id)
			->assertDontSee('point1')
			->assertSee('point2');
	}

	/** @test */
	public function TestMapThematicAreaFilter()
	{
		$admin = $this->createAdmin();

		$thematicArea1 = ThematicArea::factory()->create([
			'name' => 'thematicArea1',
		]);
		$thematicArea2 = ThematicArea::factory()->create([
			'name' => 'thematicArea2',
		]);

		$point1 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'point1'
		], null, $thematicArea1);
		$point2 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'point2'
		], null, $thematicArea2);

		Livewire::actingAs($admin)
			->test(Map::class)
			->assertSee('point1')
			->assertSee('point2')
			->set('filters.thematicArea', $thematicArea1->id)
			->assertSee('point1')
			->assertDontSee('point2')
			->set('filters.thematicArea', $thematicArea2->id)
			->assertDontSee('point1')
			->assertSee('point2');
	}

	/** @test */
	public function TestMapSearchFilter()
	{
		$admin = $this->createAdmin();

		$place1 = Place::factory()->create([
			'name' => 'place1',
		]);
		$place2 = Place::factory()->create([
			'name' => 'place2',
		]);

		$point1 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'point1'
		]);
		$point2 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'point2'
		]);

		Livewire::actingAs($admin)
			->test(Map::class)
			->assertSee('point1')
			->assertSee('point2')
			->set('filters.search', $point1->name)
			->assertSee('point1')
			->assertDontSee('point2')
			->set('filters.search', $point2->name)
			->assertDontSee('point1')
			->assertSee('point2');
	}

	/** @test */
	public function TestMapCombinedFilters()
	{
		$admin = $this->createAdmin();

		$place1 = Place::factory()->create([
			'name' => 'place1',
		]);
		$place2 = Place::factory()->create([
			'name' => 'place2',
		]);

		$thematicArea1 = ThematicArea::factory()->create([
			'name' => 'thematicArea1',
		]);
		$thematicArea2 = ThematicArea::factory()->create([
			'name' => 'thematicArea2',
		]);

		$point1 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA1'
		], $place1, $thematicArea1);
		$point2 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA2'
		], $place1, $thematicArea2);
		$point3 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA3'
		], $place2, $thematicArea1);
		$point4 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA4'
		], $place2, $thematicArea2);
		$point5 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB1'
		], $place1, $thematicArea1);
		$point6 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB2'
		], $place1, $thematicArea2);
		$point7 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB3'
		], $place2, $thematicArea1);
		$point8 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB4'
		], $place2, $thematicArea2);

		Livewire::actingAs($admin)
			->test(Map::class)
			->assertSee('pointA1')
			->assertSee('pointA2')
			->assertSee('pointA3')
			->assertSee('pointA4')
			->assertSee('pointB1')
			->assertSee('pointB2')
			->assertSee('pointB3')
			->assertSee('pointB4')
			->set('filters.search', 'pointA')
			->assertSee('pointA1')
			->assertSee('pointA2')
			->assertSee('pointA3')
			->assertSee('pointA4')
			->assertDontSee('pointB1')
			->assertDontSee('pointB2')
			->assertDontSee('pointB3')
			->assertDontSee('pointB4')
			->set('filters.place', $place1->id)
			->assertSee('pointA1')
			->assertSee('pointA2')
			->assertDontSee('pointA3')
			->assertDontSee('pointA4')
			->assertDontSee('pointB1')
			->assertDontSee('pointB2')
			->assertDontSee('pointB3')
			->assertDontSee('pointB4')
			->set('filters.thematicArea', $thematicArea1->id)
			->assertSee('pointA1')
			->assertDontSee('pointA2')
			->assertDontSee('pointA3')
			->assertDontSee('pointA4')
			->assertDontSee('pointB1')
			->assertDontSee('pointB2')
			->assertDontSee('pointB3')
			->assertDontSee('pointB4');
	}

	/** @test */
	public function TestFiltersUpdateMarkers()
	{
		$admin = $this->createAdmin();

		$place1 = Place::factory()->create([
			'name' => 'place1',
		]);
		$place2 = Place::factory()->create([
			'name' => 'place2',
		]);

		$thematicArea1 = ThematicArea::factory()->create([
			'name' => 'thematicArea1',
		]);
		$thematicArea2 = ThematicArea::factory()->create([
			'name' => 'thematicArea2',
		]);

		$point1 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA1'
		], $place1, $thematicArea1);
		$point2 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA2'
		], $place1, $thematicArea2);
		$point3 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA3'
		], $place2, $thematicArea1);
		$point4 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointA4'
		], $place2, $thematicArea2);
		$point5 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB1'
		], $place1, $thematicArea1);
		$point6 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB2'
		], $place1, $thematicArea2);
		$point7 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB3'
		], $place2, $thematicArea1);
		$point8 = $this->createPointOfInterestPlaceThematicAreas([
			"name" => 'pointB4'
		], $place2, $thematicArea2);

		Livewire::actingAs($admin)
			->test(Map::class)
			->set('filters.search', 'pointA')
			->set('filters.place', $place1->id)
			->set('filters.thematicArea', $thematicArea1->id)
			->assertViewHas('activeMarkers', [$point1->id]);
	}
}
