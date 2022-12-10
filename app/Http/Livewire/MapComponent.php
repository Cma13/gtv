<?php

namespace App\Http\Livewire;

use App\Models\PointOfInterest;
use Livewire\Component;

class MapComponent extends Component
{
	public $mapOptions = [
		'center' => [
			'lat' => 9.73175,
			'lng' => 20.35300
		],
		'zoom' => 2.3
	];

	public function pointOfInterestToMarkers($pointsOfInterest) {
		$markers = [];
		foreach ($pointsOfInterest as $point) {
			$markers[] = [
				'id' => $point->id,
				'position' => [
					'lng' => (float) $point->longitude,
					'lat' => (float) $point->latitude
				],
				'content' => <<<EOT
					<dl>
						<p><b>Nombre: </b>{$point->name}</p>
						<p><b>Coordenadas: </b>{$point->latitude}, {$point->longitude}</p>
						<p><b>Sitio: </b>{$point->place->name}</p>
					</dl>
					EOT
			];
		}
		return $markers;
	}

    public function render()
    {
		$points = PointOfInterest::all();
		$markers = $this->pointOfInterestToMarkers($points);
        return view('livewire.map-component', compact('markers'));
    }
}
