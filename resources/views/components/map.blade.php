<style>
    .pac-card {
    	background-color: #fff;
    	border: 0;
    	border-radius: 2px;
    	box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
    	margin: 10px;
    	padding: 0 0.5em;
    	font: 400 18px Roboto, Arial, sans-serif;
    	overflow: hidden;
    	font-family: Roboto;
    	padding: 0;
    }

    #pac-container {
    	padding-bottom: 12px;
    	margin-right: 12px;
    }

    .pac-controls {
    	display: inline-block;
    	padding: 5px 11px;
    }

    .pac-controls label {
    	font-family: Roboto;
    	font-size: 13px;
    	font-weight: 300;
    }

    #pac-input {
    	background-color: #fff;
    	font-family: Roboto;
    	font-size: 15px;
    	font-weight: 300;
    	margin-left: 12px;
    	/* padding: 0 11px 0 13px; */
    	text-overflow: ellipsis;
    	width: 400px;
    }

    #pac-input:focus {
    	border-color: #4d90fe;
    }

    .fullscreen-pac-container[style] {
    	z-index: 2547483647 !important;
    	top: 50px !important;
    }
</style>

<div class="col-12 col-lg-12 p-2">
    <div class="col-12">
        <label class="col-sm-2 col-form-label" for="basic-default-company">
            <i class="bx bx-map"></i>
            @lang("Location")
        </label>
      
    </div>
    <div class="col-12 pt-3">
         <input id="pac-input" class="controls form-control" type="text" placeholder="Search Here...">
        <div id="googleMap" style="border: solid 3px black; width:100%;height:400px;"></div>

        <input name="lng" type="hidden" id="lng">
        <input name="lat" type="hidden" id="lat">
        
    </div>
</div>

<script
src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDqJDhzkyerG250Du1U9tUpPKtqPgim564&callback=initAutocomplete&libraries=places&v=weekly"
defer >
</script>

<script>
    function initAutocomplete() {
		var lat =  {{ $lat }};
		var lng ={{ $lng }};

	const map = new google.maps.Map(document.getElementById("googleMap"), {
		center: {
			lat: lat,
			lng:lng
		},
		zoom: 5,
		mapTypeId: "roadmap",
	});

	var myCenter = new google.maps.LatLng(lat, lng);

	var marker = new google.maps.Marker({
		position: myCenter
	});

	marker.setMap(map);

	let markers = [];

	google.maps.event.addListener(map, 'click', function (e) {

		// alert(e.latLng);

		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
		markers.length = 0;



		var lng = e.latLng.lng();
		var lat = e.latLng.lat();

		$("#lng").val(lng);
		$("#lat").val(lat);
		// map.setZoom(9);
		marker.setPosition(e.latLng);
		//   infowindow.setContent('<div>'+'Longitute'+'<strong>' + e.latLng.lng() + '</strong><br>' +
		//     'Latitude:'+'<strong>' + e.latLng.lat()+'</strong>'  + '</div>');
		//   infowindow.open(map, this);
	});
	// Create the search box and link it to the UI element.
	const input = document.getElementById("pac-input");
	const searchBox = new google.maps.places.SearchBox(input);

	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	// Bias the SearchBox results towards current map's viewport.
	map.addListener("bounds_changed", () => {
		searchBox.setBounds(map.getBounds());
	});



	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener("places_changed", () => {
		const places = searchBox.getPlaces();

		$("#lng").val(places[0]["geometry"]["location"].lng());
		$("#lat").val(places[0]["geometry"]["location"].lat());

		if (places.length == 0) {
			return;
		}

		// Clear out the old markers.
		markers.forEach((marker) => {
			marker.setMap(null);
		});
		markers = [];

		// For each place, get the icon, name and location.
		const bounds = new google.maps.LatLngBounds();

		places.forEach((place) => {
			if (!place.geometry || !place.geometry.location) {
				console.log("Returned place contains no geometry");
				return;
			}

			const icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25),
			};

			// Create a marker for each place.
			markers.push(
				new google.maps.Marker({
					map,
					//   icon,
					title: place.name,
					position: place.geometry.location,
				})
			);
			if (place.geometry.viewport) {
				// Only geocodes have viewport.
				bounds.union(place.geometry.viewport);
			} else {
				bounds.extend(place.geometry.location);
			}
		});
		map.fitBounds(bounds);
	});
}

window.initAutocomplete = initAutocomplete;

document.onfullscreenchange = function (event) {
	let target = event.target;
	let pacContainerElements = document.getElementsByClassName("pac-container");
	if (pacContainerElements.length > 0) {
		let pacContainer = document.getElementsByClassName("pac-container")[0];
		if (pacContainer.parentElement === target) {
			document.getElementsByTagName("body")[0].appendChild(pacContainer);
			pacContainer.className += pacContainer.className.replace("fullscreen-pac-container", "");
		} else {
			target.appendChild(pacContainer);
			pacContainer.className += " fullscreen-pac-container";
		}
	}
};
</script>