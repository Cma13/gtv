<?php

namespace App\Http\Livewire\Admin\Video;

use App\Jobs\ProcessVideo;
use App\Models\PointOfInterest;
use App\Models\Video;
use getID3;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateVideo extends Component
{
    use WithFileUploads;

    public $pointsOfInterest = [], $thematicAreas = [], $order = 1;
    public $videoTemporaryUrl;

    protected $listeners = ['openCreationModal'];

    public $createForm = [
        'open' => false,
        'file' => null,
        'pointOfInterest' => '',
        'thematicArea' => '',
        'description' => '',
    ];

    protected $rules = [
        'createForm.file' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
        'createForm.pointOfInterest' => 'required',
        'createForm.thematicArea' => 'required|exists:thematic_areas,id',
        'createForm.description' => 'required|string|max:2000',
    ];

    protected $validationAttributes = [
        'createForm.file' => 'vídeo',
        'createForm.pointOfInterest' => 'punto de interés',
        'createForm.thematicArea' => 'área temática',
        'createForm.description' => 'descripción',
    ];

    public function openCreationModal()
    {
        $this->reset('createForm');

        $this->createForm['open'] = true;
        $this->getPointsOfInterest();
    }

    public function getPointsOfInterest()
    {
        $this->pointsOfInterest = PointOfInterest::all();
    }

    public function getThematicAreas()
    {
        $selectedPointOfInterest = PointOfInterest::find($this->createForm['pointOfInterest']);
        $this->thematicAreas = $selectedPointOfInterest->thematicAreas;
    }

    public function updatedCreateFormFile()
    {
        $this->videoTemporaryUrl = $this->createForm['file']->temporaryUrl();
    }

    public function updatedCreateFormPointOfInterest()
    {
        $this->reset('order');
        $this->createForm['thematicArea'] = '';
        $this->setVideoOrder();
        $this->getThematicAreas();
    }

    public function setVideoOrder()
    {
        $videos = PointOfInterest::find($this->createForm['pointOfInterest'])->videos;

        if (count($videos) > 0) {
            $this->order = \count($videos) + 1;
        }
    }

    public function save()
    {
        $this->validate();

        if (
            auth()->user()->hasRole('Administrador')
            || auth()->user()->hasRole('Profesor')
        ) {
            $fileRoute = $this->createForm['file']->store('public/videos');
            $metadata = $this->getMetaDataVideo($this->createForm['file']->getRealPath());

            $video = Video::create([
                'route' => $fileRoute,
                'point_of_interest_id' => $this->createForm['pointOfInterest'],
                'order' => $this->order,
                'creator' => auth()->user()->id,
                'updater' => null,
                'thematic_area_id' => $this->createForm['thematicArea'],
                'description' => $this->createForm['description'],
                'format' => $metadata['format'],
                'channelMode' => $metadata['channelMode'],
                'resolution' => $metadata['resolution'],
                'verified' => true
            ]);
        } elseif (auth()->user()->hasRole('Alumno')) {
            $fileRoute = $this->createForm['file']->store('public/videos');
            $metadata = $this->getMetaDataVideo($this->createForm['file']->getRealPath());

            $video = Video::create([
                'route' => $fileRoute,
                'point_of_interest_id' => $this->createForm['pointOfInterest'],
                'order' => $this->order,
                'creator' => auth()->user()->id,
                'updater' => null,
                'thematic_area_id' => $this->createForm['thematicArea'],
                'description' => $this->createForm['description'],
                'format' => $metadata['format'],
                'channelMode' => $metadata['channelMode'],
                'resolution' => $metadata['resolution'],
            ]);
        }

        ProcessVideo::dispatch($video);

        $this->reset('videoTemporaryUrl');
        $this->reset('createForm');
        $this->emit('videoCreated');
        $this->emitTo('admin.video.list-videos', 'render');
        $this->emitTo('admin.user-profile', 'render');
    }

    public function getMetaDataVideo($fileRoute)
    {
        $getID3 = new getID3;
        $respuesta = $getID3->analyze($fileRoute);

        return [
            'format' => $respuesta['fileformat'],
            'channelMode' => $respuesta['audio']['channelmode'],
            'resolution' => $respuesta['video']['resolution_x'] . 'x' . $respuesta['video']['resolution_y']
        ];
    }

    public function render()
    {
        return view('livewire.admin.video.create-video');
    }
}
