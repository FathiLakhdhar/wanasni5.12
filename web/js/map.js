/**
 * Created by Toshiba on 28-02-2016.
 */

var map, infowindow;
var places = [];

var directionsService = new google.maps.DirectionsService;
var directionsDisplay = new google.maps.DirectionsRenderer;

var $Origine;
var $distination;
var $container ;
var $Segments ;

if ($('#wanasni_trajetbundle_trajetunique_frequence').val() === 'UNIQUE') {

    console.log('UNIQUE');

     $Origine = $('#wanasni_trajetbundle_trajetunique_Origine_lieu');
     $distination = $('#wanasni_trajetbundle_trajetunique_Destination_lieu');
     $container = $('div#wanasni_trajetbundle_trajetunique_waypoints');
     $Segments = $('div#wanasni_trajetbundle_trajetunique_Segments');


} else {
    console.log('REGULAR');

    $Origine = $('#wanasni_trajetbundle_trajetregulier_Origine_lieu');
    $distination = $('#wanasni_trajetbundle_trajetregulier_Destination_lieu');
    $container = $('div#wanasni_trajetbundle_trajetregulier_waypoints');
    $Segments = $('div#wanasni_trajetbundle_trajetregulier_Segments');
}


function initialize() {
    //var map;
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

    document.getElementById('btn-route').addEventListener('click', function () {
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


function getDurationText(secs) {

    var sec_num = parseInt(secs, 10); // don't forget the second param
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    //if (hours   > 1) {hours   = "0"+hours;}
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    var time = hours + ':' + minutes;


    return time;
}

function getDistanceText(metre) {
    return metre / 1000 + ' km';
}


function prixTotal(){
    var InputTotalPrix;
    var prixTotal=0;

    if($('#wanasni_trajetbundle_trajetunique_frequence').val() === 'UNIQUE'){

        InputTotalPrix= $('#wanasni_trajetbundle_trajetunique_totalPrix');
    }else {
        InputTotalPrix= $('#wanasni_trajetbundle_trajetregulier_totalPrix');
    }

    $Segments.find('input.prix').each(function(){
        prixTotal+=parseInt($(this).val());
    });

    if(prixTotal){
        InputTotalPrix.val(prixTotal);
    }else {
        InputTotalPrix.val(0);
    }

}

function setPrixOptimal(input,$metre){

    var prixOpt=0;


    var url=$Segments.data("prix-optimal-url");
    url = url.replace("__METRE__", $metre);

    $.getJSON(url, {ajax: "true"}, function (data) {
        prixOpt= data['PrixOptimal'];
        input.val(prixOpt);
        //prixTotal();
    });

}


function NewSegment(route, index) {


    var $prototype = $($Segments.attr('data-prototype')
        .replace(/__name__label__/g,
            route.legs[index].start_address.slice(0, 15)
            + '... <i class="ion ion-ios-arrow-thin-right"></i> '
            + route.legs[index].end_address.slice(0, 15) + '... <br> <small>'+
            route.legs[index].distance.text+'<br>'+
            route.legs[index].duration.text+' </small> <br> '

        )
        .replace(/__name__/g, index)
    );

    var inputPrix = $prototype.find('input.prix');
    var inputDistance = $prototype.find('input.distance');
    var inputDuration = $prototype.find('input.duration');
    var inputOrder = $prototype.find('input.order');



    inputDistance.val(route.legs[index].distance.text);
    inputDuration.val(getDurationText(route.legs[index].duration.value));
    inputOrder.val(index);

    var parentPrix = inputPrix.parent();
    var parentDistance = inputDistance.parent();
    var parentDuration = inputDuration.parent();


    parentPrix.addClass('input-group form-group');
    parentDistance.addClass('input-group form-group');
    parentDuration.addClass('input-group form-group');

    var spanPrix     = $('<span class="input-group-addon bg-darkgrey white">Prix &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</span>');
    var spanDistance = $('<span class="input-group-addon bg-darkgrey white">Distance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</span>');
    var spanDuration = $('<span class="input-group-addon bg-darkgrey white">Durée estimée :</span>');


    var spanTND = $('<span class="input-group-addon bg-darkgrey white">TND</span>');


    parentDistance.prepend(spanDistance);
    parentDuration.prepend(spanDuration);

    parentPrix.prepend(spanPrix);
    parentPrix.append(spanTND);


    var $segment = $('<li class="segment alert alert-info"></li>');
    $segment.append($prototype);

    var $a=$('<a href="Javascript:void(0);" data-metre="'+route.legs[index].distance.value+'" class="label label-success">Prix Optimal</a>');

    $a.on('click',function(){
        setPrixOptimal(inputPrix, route.legs[index].distance.value);
    });

    $segment.append($a);

    $Segments.append($segment);



    inputPrix.keypress(function (e) {
        if (e.which < 48 || e.which > 57) {
            return false;
        }
    });


    inputPrix.on("keyup keydown blur",function(){
        prixTotal();
    });


}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {


    if ($Origine.val().length > 0 && $distination.val().length > 0) {

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


                var totalDistance = 0;
                var input_totalDistance = $('.totalDistance');
                var totalDuration = 0;
                var input_totalDuration = $('.totalDuration');

                var summaryPanel = document.getElementById('directions-panel');
                summaryPanel.innerHTML = '';


                $('ul.Segments li.segment').each(function () {
                    $(this).remove();
                });


                // For each route, display summary information.
                for (var i = 0; i < route.legs.length; i++) {
                    totalDuration += route.legs[i].duration.value;
                    totalDistance += route.legs[i].distance.value;
                    NewSegment(route, i);
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



$(document).ready(function(){

    $Segments.children('div').each(function(){
        $(this).remove();
    });
    calculateAndDisplayRoute(directionsService,directionsDisplay);
});



