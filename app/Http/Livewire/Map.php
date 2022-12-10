<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PointOfInterest;
use App\Models\User;

class Map extends Component
{
	use WithPagination;

	public $search;
	public $searchColumn = 'id';

	public $sortField = 'id';
	public $sortDirection = 'desc';

	protected $queryString = ['search'];

	public function sort($field)
	{
		if ($this->sortField != $field) {
			$this->sortField = $field;
			$this->sortDirection = 'asc';
		} else {
			$this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
		}

	}

	public function resetFilters()
	{
		$this->reset(['search', 'sortField', 'sortDirection']);
		$this->resetPage();
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function render()
	{
		$points = PointOfInterest::where($this->searchColumn, 'like', '%' . $this->search . '%')
			->where('verified', true)
			->orderBy($this->sortField, $this->sortDirection)
			->paginate(10);

		return view('livewire.map', compact('points'));
	}
}
