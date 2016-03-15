/**
 * Created by Toshiba on 15-03-2016.
 */




function toggleDateAndTimeBlock(regular) {
    $("#trajet-unique").toggle(!regular);
    $("#trajet-regular").toggle(regular);
}



function updateRoundTripChanged() {
    if (true === $("#wanasni_trajetbundle_trajet_round_trip").is(":checked")) {
        $(".return-container").show()
    } else {
        $(".return-container").hide()
    }
}


function updateFrequencesChanged(){

    var index=$('.nav-tabs li.active').index();

    if (index==0){
        $('#wanasni_trajetbundle_trajet_frequence').val("UNIQUE");
    }else{
        $('#wanasni_trajetbundle_trajet_frequence').val("REGULAR");
    }

    $('.nav-tabs li').eq(0).on('click', function(){
        $('#wanasni_trajetbundle_trajet_frequence').val("UNIQUE");
    });
    $('.nav-tabs li').eq(1).on('click', function(){
        $('#wanasni_trajetbundle_trajet_frequence').val("REGULAR");
    });




}


$( document ).ready(function() {

    updateFrequencesChanged();


    $("#wanasni_trajetbundle_trajet_round_trip").on("change", updateRoundTripChanged);

    updateRoundTripChanged();


});