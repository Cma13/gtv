<div class="w-full h-full">
	<div id="map" class="w-full h-full">
	</div>
	<script src="https://maps.googleapis.com/maps/api/js?key={{ config('api-keys.google-maps-api') }}&callback=initMap&v=weekly" defer></script>
	<script>
		let map, activeInfoWindow;
		let markersMap = new Map();

		function initMap() {
			map = new google.maps.Map(document.getElementById("map"), @js($mapOptions));
			updateOrCreateMarkers(@js($markers));
		}

		function updateOrCreateMarkers(markers) {
			if (!Array.isArray(markers)) markers = new Array(markers);
			markers.forEach(markerDetails => {
				const newMarker = new google.maps.Marker({
					position: markerDetails.position,
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

		function deleteMarkers(...id) {
			id.flat().forEach(id => {
				markersMap.get(id)?.setMap(null);
				markersMap.delete(id);
			})
		}

		function enableMarkers(...id) {
			id.flat().forEach(id => markersMap.get(id)?.setMap(map));
		}

		function disableMarkers(...id) {
			id.flat().forEach(id => markersMap.get(id)?.setMap(null));
		}

		function syncMarkers(...enabledId) {
			enabledId = enabledId.flat().map(String);
			markersMap.forEach((marker, id) => marker.setMap(enabledId.includes(id) ? map : null));
		}
	</script>
</div>
