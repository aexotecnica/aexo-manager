	var cargado = false;
	var infoWindow;
	function cargarMapa(latitud, longitud){
		if (!cargado){
			cargado = true;

			var input = document.getElementById('txtDomicilio');
			autocomplete = new google.maps.places.Autocomplete(input);

			google.maps.event.addListener(autocomplete, 'place_changed', function() {
			    infoWindow.close();
			    if (marker!= null)
			    	marker.setVisible(false);

			    var place = autocomplete.getPlace();
			    
			    if (!place.geometry) {
			      return;
			    }

			    // If the place has a geometry, then present it on a map.
			    if (place.geometry.viewport) {
			      map.fitBounds(place.geometry.viewport);
			    } else {
			      map.setCenter(place.geometry.location);
			      map.setZoom(17);  // Why 17? Because it looks good.
			    }
			    iconFile = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
			    if (marker==null)
			    	var marker = new google.maps.Marker({map: map});
			    
			    marker.setIcon(/** @type {google.maps.Icon} */({
					url: iconFile,
					size: new google.maps.Size(71, 71),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(17, 34),
					scaledSize: new google.maps.Size(35, 35)
			    }));
			    marker.setPosition(place.geometry.location);
			    marker.setVisible(true);

			    var address = '';
			    if (place.address_components) {
			      address = [
			        (place.address_components[0] && place.address_components[0].short_name || ''),
			        (place.address_components[1] && place.address_components[1].short_name || ''),
			        (place.address_components[2] && place.address_components[2].short_name || '')
			      ].join(' ');
			    }
				
				completarCamposDireccion(place);
			    
			    infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
			    infoWindow.open(map, marker);
		  	});
			/*
			var myLatlng = new google.maps.LatLng(latitud,longitud);
			var mapOptions = {
				zoom: 8,
				center: myLatlng
			}
			var map = new google.maps.Map(document.getElementById('map-ubicacionCliente'), mapOptions);

			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: 'Hello World!'
			});
			*/

			var myLatlng;
			var mapOptions;
			var map;
			if (latitud != 0){
				myLatlng = new google.maps.LatLng(latitud,longitud);
				mapOptions = {
					zoom: 8,
					center: myLatlng
				}
				map = new google.maps.Map(document.getElementById('map-ubicacionCliente'), mapOptions);
				marcarEnMapa(myLatlng,map);
			}else{
				myLatlng = new google.maps.LatLng(-37, -423);
				mapOptions = {
					center: myLatlng,
					zoom: 4
				}
				map = new google.maps.Map(document.getElementById('map-ubicacionCliente'), mapOptions);
			}


			infoWindow = new google.maps.InfoWindow();
		}

	}

	function completarCamposDireccion(place){
			res = JSON.search( place, '//*[types="street_number"]' );
			if (res.length > 0)
				$("#txtNumero").val(res[0].short_name);

			res = JSON.search( place, '//*[types="route"]' );
			if (res.length > 0)
				$("#txtCalle").val(res[0].short_name);

			res = JSON.search( place, '//*[types="neighborhood"]' );
			if (res.length > 0)
				$("#txtLocalidad").val(res[0].short_name);

			res = JSON.search( place, '//*[types="administrative_area_level_1"]' );
			if (res.length > 0)
				$("#selProvincia").val(jsProvincias[res[0].short_name]);

			$("#txtLatitud").val(place.geometry.location.G);
			$("#txtLongitud").val(place.geometry.location.K);
	}


	function marcarEnMapa(myLatlng, map){
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Hello World!'
		});
	}

   function searchLocations() {
     var address = document.getElementById("txtDomicilio").value;
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
     var searchUrl = 'http://aexo.com.ar/index.php/cliente/getMapa/' + center.lat() + '/' + center.lng() + '/' + radius;
     downloadUrl(searchUrl, function(data) {
	 //alert(data);
       var xml = parseXml(data);
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