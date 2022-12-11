<?php

namespace App\Http\Livewire;

use App\Models\Place;
use App\Models\ThematicArea;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PointOfInterest;

class Map extends Component
{
	use WithPagination;

	public $sort = [
		'field' => 'point_of_interests.id',
		'direction' => 'asc'
	];

	public $filters = [
		'search' => '',
		'place' => '',
		'thematicArea' => ''
	];

	public $selectAllMarkers = true;
	public $activeMarkers = [];
	public $initialPoints = [];


	public function mount() {
		$this->initialPoints = PointOfInterest::all();
		$this->activeMarkers = $this->initialPoints->pluck('id')->toArray();
	}

	public function updatedSelectAllMarkers() {
		if ($this->selectAllMarkers) {
			$this->activeMarkers = $this->pointsListQuery()->get()->pluck('id')->toArray();
			$this->emit('syncMarkers', $this->activeMarkers);
		} else {
			$this->activeMarkers = [];
			$this->emit('syncMarkers', $this->activeMarkers);
		}
	}

	public function updatedActiveMarkers() {
		$this->selectAllMarkers = false;
		$this->emit('syncMarkers', $this->activeMarkers);
	}

	public function sort($field)
	{
		if ($this->sort['field'] != $field) {
			$this->sort['field'] = $field;
			$this->sort['direction'] = 'asc';
		} else {
			$this->sort['direction'] = $this->sort['direction'] == 'asc' ? 'desc' : 'asc';
		}

	}

	public function updatedFilters()
	{
		$this->activeMarkers = $this->pointsListQuery()->get()->pluck('id')->toArray();
		$this->emit('syncMarkers', $this->activeMarkers);
		$this->selectAllMarkers = true;
		$this->resetPage();
	}

	private function pointsListQuery() {
		$pointsList = PointOfInterest::query()
			->where('point_of_interests.verified', true);
		if ($this->filters['search']) {
			$pointsList = $pointsList->where('point_of_interests.name', 'like', '%' . $this->filters['search'] . '%');
		}
		if ($this->filters['place']) {
			$pointsList = $pointsList->where('point_of_interests.place_id', '=', $this->filters['place']);
		}
		if ($this->filters['thematicArea']) {
			$pointsList = $pointsList->whereHas('thematicAreas', function($query) {
				$query->where('id', '=', $this->filters['thematicArea']);
			});
		}
		return $pointsList;
	}

	public function render()
	{
		$pointsList = $this->pointsListQuery()
			->orderBy($this->sort['field'], $this->sort['direction']);
		if ($this->sort['field'] == 'places.name') {
			$pointsList = $pointsList->addSelect('point_of_interests.*')
				->join('places', 'point_of_interests.place_id', '=', 'places.id');
		}
		$pointsList = $pointsList->paginate(10);

		$places = Place::orderBy('name', 'asc')->get();
		$thematicAreas = ThematicArea::orderBy('name', 'asc')->get();

		return view('livewire.map', compact('pointsList', 'places', 'thematicAreas'));
	}
}
