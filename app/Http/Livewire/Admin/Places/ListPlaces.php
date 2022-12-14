<?php

namespace App\Http\Livewire\Admin\Places;

use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ListPlaces extends Component
{
    use WithPagination;

    public $listeners = ['delete', 'render'];

    public $search;
    public $searchColumn = 'id';

    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $queryString = ['search'];

    public $detailsModal = [
        'open' => false,
        'id' => null,
        'name' => null,
        'description' => null,
        'creatorName' => null,
        'creatorId' => null,
        'updaterName' => null,
        'updaterId' => null,
        'deletedAt' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public function show(Place $place)
    {
        $this->detailsModal['open'] = true;
        $this->detailsModal['id'] = $place->id;
        $this->detailsModal['name'] = $place->name;
        $this->detailsModal['description'] = $place->description;
        $this->detailsModal['creatorName'] = $place->creator ? User::find($place->creator)->name : null;
        $this->detailsModal['creatorId'] = $place->creator;
        $this->detailsModal['updaterName'] = $place->updater ? User::find($place->updater)->name : null;
        $this->detailsModal['updaterId'] = $place->updater;
        $this->detailsModal['createdAt'] = $place->created_at;
        $this->detailsModal['updatedAt'] = $place->updated_at;
    }

    public function delete(Place $place)
    {
		if ($place->pointsOfInterest->isNotEmpty()) {
			toastr()->error('Hay puntos de interés en este lugar. No se puede eliminar.', 'Error', ['timeOut' => 1000]);
		} else {
			$isDeleted = $place->delete();

			if ($isDeleted) {
				Log::alert('Place with name ' . $place->name . ' was deleted by user with ID ' . auth()->user()->id .$place);
			}
		}
    }

    public function sort($field)
    {
        if ($this->sortField === $field && $this->sortDirection !== 'desc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
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
        if (auth()->user()->hasRole('Alumno')) {
            $places = Place::where('creator', auth()->user()->id)
                ->where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->where('verified', true)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        } else {
            $places = Place::where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->where('verified', true)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        }

        return view('livewire.admin.places.list-places', compact('places'));
    }
}
