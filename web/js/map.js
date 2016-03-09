/**
 * Created by Toshiba on 28-02-2016.
 */

var map, infowindow;
var markers = [];
var places= [];
var autocomplete;




function initialize() {

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;

    var mapProp = {
        center: new google.maps.LatLng(33.7774359, 9.4269145),
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        panControl: false,
        zoomControl: false,
        streetViewControl: false
    };
    map = new google.maps.Map(document.getElementById("map"), mapProp);

    directionsDisplay.setMap(map);

    document.getElementById('btn-route').addEventListener('click', function() {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });
}


google.maps.event.addDomListener(window, 'load', initialize);



function AutoComplete(id){
    // Create the autocomplete object and associate it with the UI input control.
    // Restrict the search to the default country, and to place type "address".
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */ (
            document.getElementById(id) ), {
            types: ['geocode'],
            componentRestrictions: {'country': 'TN'}
        });


    autocomplete.addListener('place_changed', onPlaceChanged(autocomplete));
    autocomplete.bindTo('bounds', map);

}


// When the user selects a city, get the place details for the city and
// zoom the map in on the city.

function onPlaceChanged(autocomplete) {
    var place = autocomplete.getPlace();
    if (place.geometry) {
        map.panTo(place.geometry.location);
        map.setZoom(7);

    } else {
        window.alert("Autocomplete's returned place contains no geometry");
        return;
    }
}



function calculateAndDisplayRoute(directionsService, directionsDisplay) {

    /*
    var waypts = [];
    var checkboxArray = document.getElementById('waypoints');

        for (var i = 0; i < checkboxArray.length; i++) {
            if (checkboxArray.options[i].selected) {
                waypts.push({
                    location: checkboxArray[i].value,
                    stopover: true
                });
            }
        }

*/
        directionsService.route({
            origin: document.getElementById('depart').value,
            destination: document.getElementById('arrivee').value,
          //  waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];


                 var summaryPanel = document.getElementById('directions-panel');
                 summaryPanel.innerHTML = '';
                 // For each route, display summary information.
                 for (var i = 0; i < route.legs.length; i++) {
                 var routeSegment = i + 1;
                 summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                 '</b><br>';
                 summaryPanel.innerHTML += route.legs[i].start_address + '<b> to </b>';
                 summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                 summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                 }

            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });



}