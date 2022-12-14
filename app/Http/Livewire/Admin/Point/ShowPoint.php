<?php

namespace App\Http\Livewire\Admin\Point;

use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use function view;

class ShowPoint extends Component
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
        'latitude' => null,
        'longitude' => null,
        'placeId' => null,
        'placeName' => null,
        'thematicAreas' => [],
        'creatorName' => null,
        'creatorId' => null,
        'updaterName' => null,
        'updaterId' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public function show(PointOfInterest $point)
    {
        $this->detailsModal['open'] = true;
        $this->detailsModal['id'] = $point->id;
        $this->detailsModal['name'] = $point->name;
        $this->detailsModal['description'] = $point->description;
        $this->detailsModal['latitude'] = $point->latitude;
        $this->detailsModal['longitude'] = $point->longitude;
        $this->detailsModal['placeId'] = $point->place->id;
        $this->detailsModal['placeName'] = $point->place->name;
        $this->detailsModal['thematicAreas'] = $point->thematicAreas;
        $this->detailsModal['creatorName'] = $point->creator ? User::find($point->creator)->name : null;
        $this->detailsModal['creatorId'] = $point->creator;
        $this->detailsModal['updaterName'] = $point->updater ? User::find($point->updater)->name : null;;
        $this->detailsModal['updaterId'] = $point->updater;
        $this->detailsModal['createdAt'] = $point->created_at;
        $this->detailsModal['updatedAt'] = $point->updated_at;
	    $this->emit('syncMarkers', [$this->detailsModal['id']], true);
    }

    public function delete(PointOfInterest $pointOfInterest)
    {
        $isDeleted = $pointOfInterest->delete();

        if($isDeleted) {
            Log::alert('Point with name ' . $pointOfInterest->name . ' was deleted by user with ID ' . auth()->user()->id .$pointOfInterest);
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

    public function orderByLugar($query, $direction)
    {
        return $query->orderBy(Place::select('name')
            ->whereColum('places.id', 'point_of_interests.place_id'), $direction);
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
        if ($this->sortField === 'place_id') {
            $points = PointOfInterest::select('point_of_interests.*')
                ->join('places', 'places.id', '=', 'point_of_interests.place_id')
                ->where('point_of_interests.' . $this->searchColumn, 'like', '%' . $this->search . '%')
                ->where('point_of_interests.verified', true)
                ->orderBy('places.name', $this->sortDirection)
                ->paginate(10);
        } else {
            $points = PointOfInterest::where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->where('verified', true)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        }

        return view('livewire.admin.point.show-point', compact('points'));
    }
}
