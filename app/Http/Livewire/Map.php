<?php

namespace App\Http\Livewire;

use App\Models\PointOfInterest;
use Livewire\Component;

class Map extends Component
{
	public $murcia = [
		'position' => [
			'lat' => -1.3437809,
			'lng' => 38.0723083
		],
		'zoom' => 9
	];

	public $size = [
		'width' => '100%',
		'height' => '800px'
	];

	private function pointOfInterestToMarkers($pointsOfInterest) {
		$markers = [];
		foreach ($pointsOfInterest as $point) {
			$markers[] = [
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
	    $mapOptions = [
	    'center' => [
		    'lat' => 9.73175,
		    'lng' => 20.35300
	    ],
	    'zoom' => 2.3
    ];
		$points = PointOfInterest::all();
		$markers = $this->pointOfInterestToMarkers($points);
        return view('livewire.map', compact('markers', 'mapOptions'));
    }
}
