<?php

namespace App\Http\Livewire\Admin\Point;

use App\Jobs\ProcessPointOfInterest;
use App\Models\Place;
use App\Models\PointOfInterest;
use Livewire\Component;
use function view;
use Illuminate\Support\Facades\Log;

class CreatePoint extends Component
{
    public $latitude, $longitude;
    public $places = [];

    protected $listeners = ['openCreationModal'];

    public $createForm = [
        'open' => false,
        'name' => '',
        'latitude' => '',
        'longitude' => '',
        'place' => '',
    ];

    protected $rules = [
        'createForm.name' => 'required',
        'createForm.latitude' => 'required|numeric',
        'createForm.longitude' => 'required|numeric',
        'createForm.place' => 'required|exists:places,id',
    ];

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.latitude' => 'latitud',
        'createForm.longitude' => 'longitud',
        'createForm.place' => 'sitio',
    ];

    public function openCreationModal()
    {
        $this->createForm['open'] = true;
        $this->getPlaces();
    }

    public function getPlaces()
    {
        $this->place = Place::all();
    }

    public function mount()
    {
        $this->places = Place::all();
    }

    public function save()
    {
        $this->validate();

        if (
            auth()->user()->hasRole('Administrador')
            || auth()->user()->hasRole('Profesor')
        ) {
            $pointOfInterest = PointOfInterest::create([
                'name' => $this->createForm['name'],
                'latitude' => $this->createForm['latitude'],
                'longitude' => $this->createForm['longitude'],
                'place_id' => $this->createForm['place'],
                'creator' => auth()->user()->id,
                'updater' => null,
                'verified' => true,
            ]);
        } else if(auth()->user()->hasRole('Alumno')) {
            $pointOfInterest = PointOfInterest::create([
                'name' => $this->createForm['name'],
                'latitude' => $this->createForm['latitude'],
                'longitude' => $this->createForm['longitude'],
                'place_id' => $this->createForm['place'],
                'creator' => auth()->user()->id,
                'updater' => null,
            ]);
        }
        $isCreated = $pointOfInterest;
        if ($isCreated) {
            Log::info('User with ID ' . auth()->user()->id . 'was created a point of interest with name ' . $pointOfInterest->name .$pointOfInterest);
        }

        ProcessPointOfInterest::dispatch($pointOfInterest);

        $this->reset('createForm');
        $this->emit('PointCreated');
        $this->emitTo('admin.point.show-point', 'render');
        $this->emitTo('admin.user-profile', 'render');
    }

    public function render()
    {
        return view('livewire.admin.point.create-point');
    }
}
