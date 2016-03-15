/**
 * Created by Toshiba on 28-02-2016.
 */

var map, infowindow;
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





// When the user selects a city, get the place details for the city and
// zoom the map in on the city.



function calculateAndDisplayRoute(directionsService, directionsDisplay) {

    var waypts = [];


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
                 summaryPanel.innerHTML += route.legs[i].duration.text + '<br>';
                 summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                 }

            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });



}