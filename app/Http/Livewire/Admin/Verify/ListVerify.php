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
        'DISTANCIA',
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
        'AREA TEMATICA',
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
        'AREA TEMATICA',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACION',
        'FECHA ACTUALIZACION',
        ''
    ];

    public function verifyElement($elementId, $model)
    {
        if($model === 'point') {
            $point = PointOfInterest::find($elementId);
            $point->verified = true;
            $point->save();
            toastr()->success('Punto de interés verificado', '¡Verificado!', ['timeOut' => 1000]);
        } else if($model === 'place') {
            $place = Place::find($elementId);
            $place->verified = true;
            $place->save();
            toastr()->success('Lugar verificado', '¡Verificado!', ['timeOut' => 1000]);
        } else if($model === 'video') {
            $video = Video::find($elementId);
            $video->verified = true;
            $video->save();
            toastr()->success('Video verificado', '¡Verificado!', ['timeOut' => 1000]);
        } else if($model === 'photo') {
            $photo = Photography::find($elementId);
            $photo->verified = true;
            $photo->save();
            toastr()->success('Fotografía verificada', '¡Verificado!', ['timeOut' => 1000]);
        }
        $this->emitTo('admin.user-profile', 'render');
    }

    public function render()
    {
        $points = PointOfInterest::where('verified', false)
            ->paginate(10);
        $places = Place::where('verified', false)
            ->paginate(10);
        $videos = Video::where('verified', false)
            ->paginate(10);
        $photos = Photography::where('verified', false)
            ->paginate(10);

        return view('livewire.admin.verify.list-verify', compact('points', 'places', 'videos', 'photos'));
    }
}
