	var map;
	var markers = [];
	var infoWindow;
	var locationSelect;
	var cityCircle;
	var zoomLevel;
	
	var rendererOptions = {
		'draggable': true
	};
	var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
	var directionsService = new google.maps.DirectionsService();

	function load() {
		map = new google.maps.Map(document.getElementById("map"), {
					center: new google.maps.LatLng(-37, -423),
					zoom: 4,
					mapTypeId: 'roadmap',
					mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
				});
		infoWindow = new google.maps.InfoWindow();
		directionsDisplay.setMap(map);

		google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
			computeTotalDistance(directionsDisplay.directions);
		});
		
		var input = document.getElementById('start');
		autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.bindTo('bounds', map);

		var input = document.getElementById('end');
		autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.bindTo('bounds', map);
	}


	function computeTotalDistance(result) {
		var DePoly = result.routes[0].overview_path;
		var polyline = new google.maps.Polyline({map:map, path:DePoly});

		searchLocationsNear(DePoly);
		polyline.setMap(null);
	}
		
	function calcRoute() {
		var start = document.getElementById('start').value;
		var end = document.getElementById('end').value;
	
		var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
		};

		directionsService.route(request, function(response, status) {
			//var OverPoly = response.routes[0].overview_path;
			//var DePoly = google.maps.geometry.encoding.decodePath(OverPoly);
			var DePoly = response.routes[0].overview_path;
			var polyline = new google.maps.Polyline({map:map, path:DePoly});
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			}
			//alert(DePoly.length);
			searchLocationsNear(DePoly);
			polyline.setMap(null);
		});
	}

	function buscarCercanos(OverPoly){
		alert("hola");
	}

	function clearLocations() {
		infoWindow.close();
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
		markers.length = 0;
	}

	function searchLocationsNear(DePoly) {
		$('#tablaLugares tr td').parent().remove();
		var zoom;
		var contMarker=0;
		var radius = document.getElementById('radiusSelect').value;
		clearLocations(); 
		for (var j = 0; j < DePoly.length; j++) {
			center = DePoly[j];
			var searchUrl = baseUrl + 'index.php/clientes/getMapa/' + center.lat() + '/' + center.lng() + '/' + radius;
			downloadUrl(searchUrl, function(data) {
				var xml = parseXml(data.substr(1));
				var markerNodes = xml.documentElement.getElementsByTagName("inst");
				var bounds = new google.maps.LatLngBounds();
				for (var i = 0; i < markerNodes.length; i++) {
					var name = markerNodes[i].getAttribute("nombre");
					var address = markerNodes[i].getAttribute("address");
					var distance = parseFloat(markerNodes[i].getAttribute("distance"));
					var idTipoCliente= markerNodes[i].getAttribute("idTipoCliente");
					var latlng = new google.maps.LatLng(
					parseFloat(markerNodes[i].getAttribute("lat")),
					parseFloat(markerNodes[i].getAttribute("lng")));
					contMarker = createTable(name, distance, contMarker);
					createMarker(latlng, name, address,idTipoCliente);
					bounds.extend(latlng);
				}
			});
		}
	}

	function createMarker(latlng, name, address,tipo) {
		var html = "<b>" + name + "</b> <br/>" + address;
		var marker = new google.maps.Marker({
			map: map,
			position: latlng
		});
		if (tipo == 1){
			iconFile = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; 
			marker.setIcon(iconFile) 
		}else if (tipo == 2){
			iconFile = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'; 
			marker.setIcon(iconFile) 
		}else if (tipo == 3){
			iconFile = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'; 
			marker.setIcon(iconFile) 
		}
		
		google.maps.event.addListener(marker, 'click', function() {
			infoWindow.setContent(html);
			infoWindow.open(map, marker);
		});
		markers.push(marker);
	}

	function downloadUrl(url, callback) {
		var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
		request.onreadystatechange = function() {
			if (request.readyState == 4) {
				request.onreadystatechange = doNothing;
				callback(request.responseText, request.status);
			}
		};

		request.open('GET', url, true);
		request.send(null);
	}

	function parseXml(str) {
		if (window.ActiveXObject) {
			var doc = new ActiveXObject('Microsoft.XMLDOM');
			doc.loadXML(str);
			return doc;
		} else if (window.DOMParser) {
			return (new DOMParser).parseFromString(str, 'text/xml');
		}
	}

	function doNothing() {}

	function createTable(name, distance, num) {
		var flag=false;
		$('#tablaLugares tr').each(function() {
			var nombre = $(this).find("td:first").text();    
			if (nombre==name){
				flag=true;
				if (parseFloat(distance) < parseFloat($(this).find("td:last").text()))
					$(this).find("td:last").text(distance.toFixed(2));    
			}
		});
		
		if (!flag){
			var tds = '<tr>';
			tds += '<td style="font-size:12px">' + name + '</td>';
			tds += '<td style="font-size:12px">' + distance.toFixed(2) + '</td>';
			tds += '</tr>';
			$("#tablaLugares").append(tds);    
			num +=1;
		}
		return num;
	}
	
	function ubicarMarker(num){
		google.maps.event.trigger(markers[num], 'click');
	}
