/** @format */

$.ajax({
	url: '../scripts/php/getToken.php',
	method: 'GET',
	dataType: 'json',
	success: function (response) {
		var token = response.token;

		$.ajax({
			url: '../scripts/php/fetchLocation.php',
			method: 'GET',
			dataType: 'json',
			success: function (data) {
				data.forEach(function (row) {
					var longitude = parseFloat(row.longitude);
					var latitude = parseFloat(row.latitude);

					// Initialize and add the map
					mapboxgl.accessToken = token;
					var map = new mapboxgl.Map({
						container: 'map',
						style: 'mapbox://styles/mapbox/streets-v12',
						center: [51.9887, 5.94388],
						zoom: 6, // Adjust the zoom level (lower value for further zoom out)
						interactive: false, // Disable map interaction
					});

					// Add marker to the map
					var marker = new mapboxgl.Marker()
						.setLngLat([51.9887, 5.94388])
						.addTo(map);
				});
			},
			error: function (xhr, status, error) {
				// Handle errors
				console.log('Error: ' + error);
			},
		});
	},
	error: function (xhr, status, error) {
		// Handle errors
		console.log('Error: ' + error);
	},
});
