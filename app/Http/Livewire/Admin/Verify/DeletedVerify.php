<?php

namespace App\Http\Livewire\Admin\Verify;

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\Video;
use Livewire\Component;

class DeletedVerify extends Component
{
    public $listeners = ['moveToTrash'];

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

    public function restoreElement($elementId, $model)
    {
        if ($model === 'point') {
            PointOfInterest::withTrashed()
                ->find($elementId)
                ->restore();
            toastr()->success('Punto de interés restaurado', '¡Restaurado!', ['timeOut' => 1000]);
        } else if ($model === 'place') {
            Place::withTrashed()
                ->find($elementId)
                ->restore();
            toastr()->success('Lugar restaurado', '¡Restaurado!', ['timeOut' => 1000]);
        } else if ($model === 'video') {
            Video::withTrashed()
                ->find($elementId)
                ->restore();
            toastr()->success('Video restaurado', '¡Restaurado!', ['timeOut' => 1000]);
        } else if ($model === 'photo') {
            Photography::withTrashed()
                ->find($elementId)
                ->restore();
            toastr()->success('Fotografía restaurada', '¡Restaurado!', ['timeOut' => 1000]);
        }
        $this->emitTo('admin.user-profile', 'render');
    }

    public function hardDelete($response)
    {
        $elementId = $response['elementId'];
        $model = $response['model'];

        if ($model === 'point') {
            PointOfInterest::withTrashed()
                ->find($elementId)
                ->forceDelete();
            toastr()->error('Punto de interés eliminado', '¡Eliminado!', ['timeOut' => 1000]);
        } else if ($model === 'place') {
            Place::withTrashed()
                ->find($elementId)
                ->forceDelete();
            toastr()->error('Lugar eliminado', '¡Eliminado!', ['timeOut' => 1000]);
        } else if ($model === 'video') {
            Video::withTrashed()
                ->find($elementId)
                ->forceDelete();
            toastr()->error('Video eliminado', '¡Eliminado!', ['timeOut' => 1000]);
        } else if ($model === 'photo') {
            Photography::withTrashed()
                ->find($elementId)
                ->forceDelete();
            toastr()->error('Fotografía eliminada', '¡Eliminado!', ['timeOut' => 1000]);
        }
        $this->emitTo('admin.user-profile', 'render');
    }

    public function render()
    {
        $points = PointOfInterest::onlyTrashed()
            ->paginate(10);
        $places = Place::onlyTrashed()
            ->paginate(10);
        $videos = Video::onlyTrashed()
            ->paginate(10);
        $photos = Photography::onlyTrashed()
            ->paginate(10);

        return view('livewire.admin.verify.deleted-verify', compact('points', 'places', 'videos', 'photos'));
    }
}
