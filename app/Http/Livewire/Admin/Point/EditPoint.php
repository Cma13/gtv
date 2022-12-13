<?php

namespace App\Http\Livewire\Admin\Point;

use App\Models\Place;
use App\Models\PointOfInterest;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use function view;

class EditPoint extends Component
{
    public $latitude, $longitude, $pointId;
    public $places = [];

    protected $listeners = ['openEditModal'];

    public $editForm = [
        'open' => false,
        'name' => '',
        'description' => '',
        'latitude' => '',
        'longitude' => '',
        'place' => '',
    ];

    protected $rules = [
        'editForm.name' => 'required',
        'editForm.description' => 'required|max:2000',
        'editForm.latitude' => 'required|numeric|max:90|min:-90',
        'editForm.longitude' => 'required|numeric|max:180|min:-180',
        'editForm.place' => 'required|exists:places,id',
    ];

    protected $validationAttributes = [
        'editForm.name' => 'nombre',
        'createForm.description' => 'descripción',
        'editForm.latitude' => 'latitud',
        'editForm.longitude' => 'longitud',
        'editForm.place' => 'sitio',
    ];

    public function openEditModal(PointOfInterest $point)
    {
        $this->reset(['editForm']);

        $this->pointId = $point->id;
        $this->editForm['name'] = $point->name ;
        $this->editForm['description'] = $point->description ;
        $this->editForm['latitude'] = $point->latitude;
        $this->editForm['longitude'] = $point->longitude;
        $this->editForm['place'] = $point->place->id;

        $this->getPlaces();

        $this->editForm['open'] = true;
    }

    public function getPlaces()
    {
        $this->places = Place::all();
    }

    public function update(PointOfInterest $pointOfInterest)
    {
        $this->validate();

        $isUpdated = $pointOfInterest->update([
            'updater' => auth()->user()->id,
            'name' => $this->editForm['name'],
            'description' => $this->editForm['description'],
            'latitude' => $this->editForm['latitude'],
            'longitude' => $this->editForm['longitude'],
            'place_id' => $this->editForm['place'],
        ]);
        if ($isUpdated) {
            Log::info('User with ID ' . auth()->user()->id . 'was updated a point of interest with name ' . $pointOfInterest->name .$pointOfInterest);
        }
        

        $this->editForm['open'] = false;
        $this->reset(['editForm']);

        $this->emitTo('admin.point.show-point', 'render');
        $this->emit('pointUpdated');
    }

    public function render()
    {
        return view('livewire.admin.point.edit-point');
    }
}
