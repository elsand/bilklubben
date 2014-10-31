var google_map, google_map_marker;

$(function () {
	var mapOptions = {
		center: new google.maps.LatLng(65.471568,12.207516),
		zoom: 13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	google_map = new google.maps.Map(document.getElementById('js-car-location-map'), mapOptions);
});

function showMap(lat, lng) {
	var pos = new google.maps.LatLng(lat, lng);
	google_map.setCenter(pos);
	if (google_map_marker) google_map_marker.setMap(null);
	google_map_marker = new google.maps.Marker({
	      position: pos,
	      map: google_map
	});

	$('#js-car-location-map')
		.css('marginLeft', 0)
		.lightbox_me({
			centered: true
		});
}