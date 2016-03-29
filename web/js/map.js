/**
 * Created by Toshiba on 28-02-2016.
 */

var map, infowindow;
var places= [];

var directionsService = new google.maps.DirectionsService;
var directionsDisplay = new google.maps.DirectionsRenderer;


if($('#wanasni_trajetbundle_trajetunique_frequence').val()==='UNIQUE'){

    console.log('UNIQUE');

    var $Origine=$('#wanasni_trajetbundle_trajetunique_Origine_lieu');
    var $distination=$('#wanasni_trajetbundle_trajetunique_Destination_lieu');
    var $container = $('div#wanasni_trajetbundle_trajetunique_waypoints');
    var $Segments = $('div#wanasni_trajetbundle_trajetunique_Segments');

}else {
    console.log('REGULAR');

    $Origine=$('#wanasni_trajetbundle_trajetregulier_Origine_lieu');
    $distination=$('#wanasni_trajetbundle_trajetregulier_Destination_lieu');
    $container = $('div#wanasni_trajetbundle_trajetregulier_waypoints');
    $Segments = $('div#wanasni_trajetbundle_trajetregulier_Segments');
}



function initialize() {



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

function getLocation(value) {
    var name = $(value + "_lieu").val();
    var latitude = $(value + "_latitude").val();
    var longitude = $(value + "_longitude").val();
    if (latitude && longitude) {
        latitude = parseFloat(latitude);
        longitude = parseFloat(longitude);
        return new google.maps.LatLng(latitude, longitude)
    }
    return name
}

function getStopoversLocation($container) {
    var stopoversLocation = [];

    $container.find('input[type=text]').each(function () {
        var name = $(this).attr("id").replace(new RegExp("_lieu$", "gm"), "");
        if ($("#" + name + "_lieu").length > 0) {
            var location = getLocation("#" + name);
            if (location) {
                stopoversLocation.push({location: location})
            }
        }
    });
    return stopoversLocation
}


function getDurationText(secs){

    var sec_num = parseInt(secs, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    //if (hours   > 1) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time    = hours+' heure '+minutes+' minutes';
    if(hours   > 1){
        time    = hours+' heures '+minutes+' minutes';
    }

    return time;
}

function getDistanceText(metre){
    return metre/1000+' km';
}

function NewSegment(route,index){



    var $prototype = $($Segments.attr('data-prototype')
        .replace(/__name__label__/g, route.legs[index].start_address + '<b> to </b>'+ route.legs[index].end_address )
        .replace(/__name__/g, index)
    );


    $prototype.find('.distance').val(getDistanceText(route.legs[index].distance.value));
    $prototype.find('.duration').val(getDurationText(route.legs[index].duration.value));
    $prototype.find('.order').val(index);

    var $segment=$('<li class="segment alert alert-info"></li>');
    $segment.append($prototype);

    $Segments.append($segment);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {




    if($Origine.val().length>0 && $distination.val().length>0 ){

        directionsService.route({
            origin: $Origine.val(),
            destination: $distination.val(),
            waypoints: getStopoversLocation($container),
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];


                var totalDistance=0;
                var input_totalDistance=$('.totalDistance');
                var totalDuration=0;
                var input_totalDuration=$('.totalDuration');

                 var summaryPanel = document.getElementById('directions-panel');
                 summaryPanel.innerHTML = '';



                $('ul.Segments li.segment').each(function(){
                    $(this).remove();
                });


                 // For each route, display summary information.
                 for (var i = 0; i < route.legs.length; i++) {

                    var routeSegment = i + 1;
                    summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                    '</b><br>';

                    summaryPanel.innerHTML += route.legs[i].start_address + '<b> to </b>';
                    summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                    summaryPanel.innerHTML += route.legs[i].duration.text +'<br>';
                    summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';

                     totalDuration+=route.legs[i].duration.value;
                     totalDistance+=route.legs[i].distance.value;

                     NewSegment(route,i);
                 }

                input_totalDuration.val(getDurationText(totalDuration));
                input_totalDistance.val(getDistanceText(totalDistance));

            } else {
                //window.alert('Directions request failed due to ' + status);
                console.log('Directions request failed due to ' + status);
            }
        });

    }

}





