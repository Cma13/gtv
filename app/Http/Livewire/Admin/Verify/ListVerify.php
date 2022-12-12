<?php

namespace App\Http\Livewire\Admin\Verify;

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\Video;
use Livewire\Component;

class ListVerify extends Component
{
    public $pointHeaders = [
        'QR',
        'ID',
        'NOMBRE',
        'LATITUD / LONGITUD',
        'SITIO',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACIÓN',
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
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACION',
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

    public function render()
    {
        $points = PointOfInterest::where('verified', false)
            ->where('deleted_at', null)
            ->paginate(10);
        $places = Place::where('verified', false)
            ->where('deleted_at', null)
            ->paginate(10);
        $videos = Video::where('verified', false)
            ->where('deleted_at', null)
            ->paginate(10);
        $photos = Photography::where('verified', false)
            ->where('deleted_at', null)
            ->paginate(10);

        return view('livewire.admin.verify.list-verify', compact('points', 'places', 'videos', 'photos'));
    }
}
