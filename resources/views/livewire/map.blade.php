<div>
	<div id="map" style="height:{{$size["height"]}};width:{{$size["width"]}}">
	</div>
	<script src="https://maps.googleapis.com/maps/api/js?key={{ config('api-keys.google-maps-api') }}&callback=initMap&v=weekly" defer></script>
	<script>
		let map, activeInfoWindow, markers = [];

		function initMap() {
			map = new google.maps.Map(document.getElementById("map"), @js($mapOptions));
			initMarkers();
		}

		function initMarkers() {
			@js($markers).forEach(markerDetails => {
				const newMarker = new google.maps.Marker({
					position: markerDetails.position,
					map
				});
				markers.push(newMarker);

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
	</script>
</div>
