// JavaScript Document
		//<![CDATA[
		var map;
		var markers = [];
		var infoWindow;
		var locationSelect;
	var cityCircle;
	var zoomLevel;
	var input;
	//var options;

		function load() {
		map = new google.maps.Map(document.getElementById("map"), {
			mapTypeId: 'roadmap',
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
		});
		infoWindow = new google.maps.InfoWindow();

		var position = new google.maps.LatLng(-37, -423);
		map.setOptions({
			center: position,
			zoom: 4
		});
		locationSelect = document.getElementById("locationSelect");
		locationSelect.onchange = function() {
				var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
				if (markerNum != "none"){
					google.maps.event.trigger(markers[markerNum], 'click');
				}
			};


		var populationOptions = {
			//strokeColor: "#FF0000",
			strokeOpacity: 0.8,
			strokeWeight: 2,
			//fillColor: "#FF0000",
			fillOpacity: 0.15
		};

		cityCircle = new google.maps.Circle(populationOptions);

		google.maps.event.addListener(map, 'zoom_changed', function() {
		zoomLevel = map.getZoom();
		infoWindow.setContent("Zoom: " + zoomLevel);
		if (zoomLevel == 0) {
			map.setZoom(15);
		}      
		});

		
		 var searchUrl = baseUrl + 'index.php/clientes/getMapaCompleto';
		 downloadUrl(searchUrl, function(data) {
	 //alert(data);
			 var xml = parseXml(data.substr(1));
			 var markerNodes = xml.documentElement.getElementsByTagName("inst");
			 var bounds = new google.maps.LatLngBounds();
			 for (var i = 0; i < markerNodes.length; i++) {
				 var name = markerNodes[i].getAttribute("nombre");
				 var address = markerNodes[i].getAttribute("address");
				 var idTipoCliente= markerNodes[i].getAttribute("idTipoCliente");
				 var latlng = new google.maps.LatLng(
							parseFloat(markerNodes[i].getAttribute("lat")),
							parseFloat(markerNodes[i].getAttribute("lng")));

				 createOption(name, 0, i);
				 createMarker(latlng, name, address,idTipoCliente);
				 bounds.extend(latlng);
			 }
		 if (markerNodes.length > 0){
			 map.fitBounds(bounds);
		}
		 });
		var input = document.getElementById('addressInput');
		autocomplete = new google.maps.places.Autocomplete(input);
		
	 }

	 function searchLocations() {

		 var address = document.getElementById("addressInput").value;
		 var geocoder = new google.maps.Geocoder();
		 geocoder.geocode({address: address}, function(results, status) {
			 if (status == google.maps.GeocoderStatus.OK) {
				searchLocationsNear(results[0].geometry.location);
			 } else {
				 alert(address + ' no encontrado');
			 }
		 });
	 }

	 function clearLocations() {
		 infoWindow.close();
		 for (var i = 0; i < markers.length; i++) {
			 markers[i].setMap(null);
		 }
		 markers.length = 0;

		 locationSelect.innerHTML = "";
		 var option = document.createElement("option");
		 option.value = "none";
		 option.innerHTML = "See all results:";
		 locationSelect.appendChild(option);
	 }

	 function searchLocationsNear(center) {
		 clearLocations(); 
		var zoom;
		 var radius = document.getElementById('radiusSelect').value;
		 var searchUrl = baseUrl + 'index.php/clientes/getMapa/' + center.lat() + '/' + center.lng() + '/' + radius;
		 downloadUrl(searchUrl, function(data) {
	 //alert(data);
			 var xml = parseXml(data.substr(1));
			 var markerNodes = xml.documentElement.getElementsByTagName("inst");
			 var bounds = new google.maps.LatLngBounds();
			 for (var i = 0; i < markerNodes.length; i++) {
				 var name = markerNodes[i].getAttribute("nombre");
				 var address = markerNodes[i].getAttribute("address");
				 var distance = parseFloat(markerNodes[i].getAttribute("distance"));
				 var latlng = new google.maps.LatLng(
							parseFloat(markerNodes[i].getAttribute("lat")),
							parseFloat(markerNodes[i].getAttribute("lng")));

				 createOption(name, distance, i);
				 createMarker(latlng, name, address);
				 bounds.extend(latlng);
			 }
		 if (markerNodes.length > 0){
			 map.fitBounds(bounds);
		 
		cityCircle.setMap(map);
		cityCircle.setCenter(center);
		cityCircle.setRadius(radius * 1000);
		 
			 locationSelect.style.visibility = "visible";
			 locationSelect.onchange = function() {
				 var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
				 google.maps.event.trigger(markers[markerNum], 'click');
			 };
		 if (zoomLevel > 15)
		map.setZoom(15);
		else
		map.setZoom(zoomLevel);
		}
			});
		
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

		function createOption(name, distance, num) {
			var option = document.createElement("option");
			option.value = num;
			option.innerHTML = name + "(" + distance.toFixed(1) + ")";
			locationSelect.appendChild(option);
		}

		function downloadUrl(url, callback) {
			var request = window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;

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

		//]]>
