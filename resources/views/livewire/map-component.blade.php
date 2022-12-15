<div class="w-full h-full">
	<div id="map" class="w-full h-full" wire:ignore></div>

	@push('scripts')
		<script src="https://maps.googleapis.com/maps/api/js?key={{ config('api-keys.google-maps-api') }}&callback=initMap&v=weekly" defer></script>
		<script>
			let map, activeInfoWindow;
			let markersMap = new Map();

			function initMap() {
				map = new google.maps.Map(document.getElementById("map"), @js($mapOptions));
				updateOrCreateMarkers(@js($initialMarkers));
			}

			function updateOrCreateMarkers(markers) {
				if (!Array.isArray(markers)) markers = new Array(markers);
				markers.forEach(markerDetails => {
					const newMarker = new google.maps.Marker({
						position: markerDetails.position,
						title: markerDetails.name,
						map
					});
					markersMap.set(markerDetails.id, newMarker);

					const infoWindow = new google.maps.InfoWindow({
						content: `${markerDetails.content}`,
					});

					newMarker.addListener("click", (event) => {
						if(activeInfoWindow) activeInfoWindow.close();
						infoWindow.open({
							anchor: newMarker,
							shouldFocus: false,
							map
						});
						activeInfoWindow = infoWindow;
					});
				})
			}

			function syncMarkers(enabledId, centerPoint) {
				markersMap.forEach((marker, id) => marker.setMap(enabledId.map(String).includes(String(id)) ? map : null));
				if (centerPoint) {
					map.setCenter(markersMap.get(enabledId[0]).getPosition());
					map.setZoom(10);
				}
			}

			window.addEventListener('syncMarkers', event => syncMarkers(event.detail.markers, event.detail.center));
		</script>
	@endpush
</div>
