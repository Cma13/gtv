<?php

namespace App\Http\Livewire\Admin\Video;

use App\Models\PointOfInterest;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class EditVideo extends Component
{
    public $pointsOfInterest = [];
    public $videoId, $videoRoute;

    protected $listeners = ['openEditModal'];

    public $editForm = [
        'open' => false,
        'pointOfInterest' => '',
        'description' => '',
    ];

    protected $rules = [
        'editForm.pointOfInterest' => 'required',
        'editForm.description' => 'required|string|max:2000',
    ];

    protected $validationAttributes = [
        'editForm.pointOfInterest' => 'punto de interés',
        'editForm.description' => 'descripción',
    ];

    public function openEditModal(Video $video)
    {
        $this->reset(['editForm']);

        $this->videoId = $video->id;
        $this->videoRoute = Storage::url($video->route);
        $this->editForm['pointOfInterest'] = $video->pointOfInterest->id ?? '';
        $this->editForm['description'] = $video->description;

        $this->getPointsOfInterest();

        $this->editForm['open'] = true;
    }

    public function getPointsOfInterest()
    {
        $this->pointsOfInterest = PointOfInterest::all();
    }

    public function update(Video $video)
    {
        $this->validate();

        $video->update([
            'updater' => auth()->user()->id,
            'point_of_interest_id' => $this->editForm['pointOfInterest'],
            'description' => $this->editForm['description'],
        ]);

        $this->editForm['open'] = false;
        $this->reset(['editForm']);

        $this->emitTo('admin.video.list-videos', 'render');
        $this->emit('videoUpdated');
    }

    public function render()
    {
        return view('livewire.admin.video.edit-video');
    }
}
