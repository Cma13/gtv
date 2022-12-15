<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MapComponent extends Component
{
	protected $listeners = ['syncMarkers'];

	public $mapOptions = [
		'center' => [
			'lat' => 0,
			'lng' => 20
		],
		'zoom' => 2
	];

	public $initialPoints = [];
	public $initialMarkers = [];

	public function mount() {
		$this->initialMarkers = $this->pointOfInterestToMarkers(is_iterable($this->initialPoints) ? $this->initialPoints : collect($this->initialPoints));
	}

	public function syncMarkers($markers, $center = false) {
		$this->dispatchBrowserEvent('syncMarkers', ['markers' => $markers, 'center' => $center]);
	}

	public function pointOfInterestToMarkers($pointsOfInterest) {
		$markers = [];
		foreach ($pointsOfInterest as $point) {
			if (!$point) {
				break;
			}
			$markers[] = [
				'id' => $point->id,
				'name' => $point->name,
				'position' => [
					'lng' => (float) $point->longitude,
					'lat' => (float) $point->latitude
				],
				'content' => <<<EOT
					<dl>
						<p><b>Nombre: </b>{$point->name}</p>
						<p><b>Coordenadas: </b>{$point->latitude}, {$point->longitude}</p>
						<p><b>Lugar: </b>{$point->place->name}</p>
					</dl>
					EOT
			];
		}
		return $markers;
	}

    public function render()
    {
        return view('livewire.map-component');
    }
}
