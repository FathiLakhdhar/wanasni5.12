/**
 * Created by Toshiba on 28-02-2016.
 */

var map, infowindow;
var markers = [];
var places= [];





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



function AutoComplete($id){
    // Create the autocomplete object and associate it with the UI input control.
    // Restrict the search to the default country, and to place type "address".
    var $elem=document.getElementById($id);

    var autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */
        ($elem), {
            types: ['geocode'],
            componentRestrictions: {'country': 'TN'}
        });
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();

        if (place.geometry) {
            map.panTo(place.geometry.location);
            map.setZoom(7);

            //alert(place.geometry.location.lat());
            //alert(place.geometry.location.lng());

            var $parent =$($elem).parent();
            $parent.find('input[class=latitude]').val(place.geometry.location.lat());
            $parent.find('input[class=longitude]').val(place.geometry.location.lng());

            var $db_parent=$parent.parent();

            $db_parent.find('input[class=latitude]').val(place.geometry.location.lat());
            $db_parent.find('input[class=longitude]').val(place.geometry.location.lng());


        } else {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

    });


}


// When the user selects a city, get the place details for the city and
// zoom the map in on the city.

function onPlaceChanged(autocomplete,$id) {

}



function calculateAndDisplayRoute(directionsService, directionsDisplay) {

    var waypts = [];

    var $Panel = document.getElementById('panel');


    var $container = $('div#wanasni_trajetbundle_trajet_waypoints');

    $container.find('input[type=text]').each(function() {
        var $input =document.getElementById($(this).attr('id')) ;

        waypts.push({
            location: $input.value,
            stopover: true
        });
    });


        directionsService.route({
            origin: document.getElementById('wanasni_trajetbundle_trajet_Origine_lieu').value,
            destination: document.getElementById('wanasni_trajetbundle_trajet_Destination_lieu').value,
            waypoints: waypts,
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