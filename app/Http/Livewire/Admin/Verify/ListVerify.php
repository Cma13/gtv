<?php

namespace App\Http\Livewire\Admin\Verify;

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ListVerify extends Component
{
    public $search;
    public $searchColumn = '';

    public $pointHeaders = [
        'ID',
        'NOMBRE',
        'DESCRIPCIÓN',
        'LUGAR',
        'CREADOR',
        'ACTUALIZADOR',
        ''
    ];

    public $placeHeaders = [
        'ID',
        'NOMBRE',
        'DESCRIPCIÓN',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACIÓN',
        ''
    ];

    public $videoHeaders = [
        'ID',
        'DESCRIPCIÓN',
        'PUNTO DE INTERES',
        'ORDEN',
        ''
    ];

    public $photoHeaders = [
        'ID',
        'RUTA',
        'ORDEN',
        'PUNTO DE INTERES',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACION',
        'FECHA ACTUALIZACION',
        ''
    ];

    public $detailsModalVideos = [
        'open' => false,
        'id' => null,
        'description' => null,
        'route' => null,
        'order' => null,
        'pointOfInterest' => null,
        'creatorName' => null,
        'creatorId' => null,
        'updaterName' => null,
        'updaterId' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public $detailsModalAreas = [
        'open' => false,
        'id' => null,
        'name' => null,
        'description' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public $detailsModalUsers = [
        'open' => false,
        'avatar' => null,
        'id' => null,
        'name' => '',
        'email' => '',
        'rol' => '',
        'password' => '',
        'emailVerifiedAt' => '',
        'createdAt' => '',
        'updatedAt' => '',
    ];

    public $detailsModalVisits = [
        'open' => false,
        'id' => null,
        'hour' => null,
        'deviceid' => null,
        'appversion' => null,
        'useragent' => null,
        'ssoo' => null,
        'ssooversion' => null,
        'latitude' => null,
        'longitude' => null,
        'point_of_interest_id' => null,
    ];

    public $detailsModalPoints = [
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

    public $detailsModalPlaces = [
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

    public $detailsModalPhotographies = [
        'open' => false,
        'id' => null,
        'route' => null,
        'order' => null,
        'pointOfInterestId' => null,
        'creatorId' => null,
        'creatorName' => null,
        'updaterId' => null,
        'updaterName' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public function showVideos(Video $video)
    {
        $this->detailsModalVideos['open'] = true;
        $this->detailsModalVideos['id'] = $video->id;
        $this->detailsModalVideos['description'] = $video->description;
        $this->detailsModalVideos['route'] = Storage::url($video->route);
        $this->detailsModalVideos['order'] = $video->order;
        $this->detailsModalVideos['pointOfInterest'] = $video->pointOfInterest->id;
        $this->detailsModalVideos['creatorName'] = User::find($video->creator)->name;
        $this->detailsModalVideos['creatorId'] = $video->creator;
        $this->detailsModalVideos['updaterName'] = $video->updater ? User::find($video->updater)->name : null;;
        $this->detailsModalVideos['updaterId'] = $video->updater;
        $this->detailsModalVideos['createdAt'] = $video->created_at;
        $this->detailsModalVideos['updatedAt'] = $video->updated_at;
    }

    public function showPoints(PointOfInterest $point)
    {
        $this->detailsModalPoints['open'] = true;
        $this->detailsModalPoints['id'] = $point->id;
        $this->detailsModalPoints['name'] = $point->name;
        $this->detailsModalPoints['description'] = $point->description;
        $this->detailsModalPoints['latitude'] = $point->latitude;
        $this->detailsModalPoints['longitude'] = $point->longitude;
        $this->detailsModalPoints['placeId'] = $point->place->id;
        $this->detailsModalPoints['placeName'] = $point->place->name;
        $this->detailsModalPoints['thematicAreas'] = $point->thematicAreas;
        $this->detailsModalPoints['creatorName'] = User::find($point->creator)->name;
        $this->detailsModalPoints['creatorId'] = $point->creator;
        $this->detailsModalPoints['updaterName'] = $point->updater ? User::find($point->updater)->name : null;;
        $this->detailsModalPoints['updaterId'] = $point->updater;
        $this->detailsModalPoints['createdAt'] = $point->created_at;
        $this->detailsModalPoints['updatedAt'] = $point->updated_at;
    }

    public function showPlaces(Place $place)
    {
        $this->detailsModalPlaces['open'] = true;
        $this->detailsModalPlaces['id'] = $place->id;
        $this->detailsModalPlaces['name'] = $place->name;
        $this->detailsModalPlaces['description'] = $place->description;
        $this->detailsModalPlaces['creatorName'] = User::find($place->creator)->name;
        $this->detailsModalPlaces['creatorId'] = $place->creator;
        $this->detailsModalPlaces['updaterName'] = $place->updater ? User::find($place->updater)->name : null;
        $this->detailsModalPlaces['updaterId'] = $place->updater;
        $this->detailsModalPlaces['createdAt'] = $place->created_at;
        $this->detailsModalPlaces['updatedAt'] = $place->updated_at;
    }

    public function showPhotographies(Photography $photography)
    {
        $this->detailsModalPhotographies['open'] = true;
        $this->detailsModalPhotographies['id'] = $photography->id;
        $this->detailsModalPhotographies['route'] = $photography->route;
        $this->detailsModalPhotographies['order'] = $photography->order;
        $this->detailsModalPhotographies['pointOfInterestId'] = $photography['point_of_interest_id'];
        $this->detailsModalPhotographies['creatorId'] = User::find($photography->creator)->id;
        $this->detailsModalPhotographies['creatorName'] = User::find($photography->creator)->name;
        $this->detailsModalPhotographies['createdAt'] = $photography->created_at;
        $this->detailsModalPhotographies['updatedAt'] = $photography->updated_at;
    }

    public function verifyElement($elementId, $model)
    {
        if ($model === 'point') {
            $point = PointOfInterest::find($elementId);
            $point->verified = true;
            $point->save();
            toastr()->success('Punto de interés verificado', '¡Verificado!', ['timeOut' => 1000]);
        } else if ($model === 'place') {
            $place = Place::find($elementId);
            $place->verified = true;
            $place->save();
            toastr()->success('Lugar verificado', '¡Verificado!', ['timeOut' => 1000]);
        } else if ($model === 'video') {
            $video = Video::find($elementId);
            $video->verified = true;
            $video->save();
            toastr()->success('Video verificado', '¡Verificado!', ['timeOut' => 1000]);
        } else if ($model === 'photo') {
            $photo = Photography::find($elementId);
            $photo->verified = true;
            $photo->save();
            toastr()->success('Fotografía verificada', '¡Verificado!', ['timeOut' => 1000]);
        }
        $this->emitTo('admin.user-profile', 'render');
    }

    public function moveToTrash($elementId, $model)
    {
        if ($model === 'point') {
            $point = PointOfInterest::find($elementId);
            $point->delete();
            toastr()->error('Punto de interés eliminado', '¡Eliminado!', ['timeOut' => 1000]);
        } else if ($model === 'place') {
            $place = Place::find($elementId);
            $place->delete();
            toastr()->error('Lugar eliminado', '¡Eliminado!', ['timeOut' => 1000]);
        } else if ($model === 'video') {
            $video = Video::find($elementId);
            $video->delete();
            toastr()->error('Video eliminado', '¡Eliminado!', ['timeOut' => 1000]);
        } else if ($model === 'photo') {
            $photo = Photography::find($elementId);
            $photo->delete();
            toastr()->error('Fotografía eliminada', '¡Eliminado!', ['timeOut' => 1000]);
        }
        $this->emitTo('admin.user-profile', 'render');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'searchColumn']);
    }

    public function render()
    {
        $points = [];
        $places = [];
        $videos = [];
        $photos = [];

        if (!$this->searchColumn && !$this->search) {
            $points = PointOfInterest::where('name', 'like', '%' . $this->search . '%')
                ->where('verified', false)
                ->where('deleted_at', null)
                ->paginate(10);
            $places = Place::where('name', 'like', '%' . $this->search . '%')
                ->where('verified', false)
                ->where('deleted_at', null)
                ->paginate(10);
            $videos = Video::where('verified', false)
                ->where('deleted_at', null)
                ->paginate(10);
            $photos = Photography::where('verified', false)
                ->where('deleted_at', null)
                ->paginate(10);
        } else if ($this->search) {
            $points = PointOfInterest::where('name', 'like', '%' . $this->search . '%')
                ->where('verified', false)
                ->where('deleted_at', null)
                ->paginate(10);
            $places = Place::where('name', 'like', '%' . $this->search . '%')
                ->where('verified', false)
                ->where('deleted_at', null)
                ->paginate(10);
        } else {
            switch ($this->searchColumn) {
                case 'points_of_interest':
                    $points = PointOfInterest::where('name', 'like', '%' . $this->search . '%')
                        ->where('verified', false)
                        ->where('deleted_at', null)
                        ->paginate(10);
                    break;
                case 'places':
                    $places = Place::where('name', 'like', '%' . $this->search . '%')
                        ->where('verified', false)
                        ->where('deleted_at', null)
                        ->paginate(10);
                    break;
                case 'videos':
                    $videos = Video::where('verified', false)
                        ->where('deleted_at', null)
                        ->paginate(10);
                    break;
                case 'photos':
                    $photos = Photography::where('verified', false)
                        ->where('deleted_at', null)
                        ->paginate(10);
                    break;
            }
        }
        return view('livewire.admin.verify.list-verify', compact('points', 'places', 'videos', 'photos'));
    }
}
