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
        'LATITUD',
        'LONGITUD',
        'SITIO',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACIÓN'
    ];

    public $placeHeaders = [
        'ID',
        'NOMBRE',
        'DESCRIPCIÓN',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACIÓN'
    ];

    public $videoHeaders = [
        'ID',
        'DESCRIPCIÓN',
        'PUNTO DE INTERES',
        'ORDEN',
        'AREA TEMATICA',
        'CREADOR',
        'ACTUALIZADOR',
        'FECHA CREACION'
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
        'FECHA ACTUALIZACION'
    ];



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
