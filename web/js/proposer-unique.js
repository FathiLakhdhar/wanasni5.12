/**
 * Created by Toshiba on 15-03-2016.
 */

function updateRoundTripChanged() {
    if (true === $("#wanasni_trajetbundle_trajet_round_trip").is(":checked")) {
        $(".return-container").show()
    } else {
        $(".return-container").hide()
    }
}


var options_Date=
{
    dateFormat: "yy-mm-dd",
    minDate: new Date(),
    maxDate: "+3m",
    monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre" ],
    dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
    dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
    dayNamesShort: [ "Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam" ]
};

function UniqueTrip() {

        $("[datepicker=date_allet_unique]").datepicker(jQuery.extend({}, options_Date,{
            onClose: function( selectedDate ) {
                $( "[datepicker=date_retour_unique]" ).datepicker( "option", "minDate", selectedDate );
            }
        }));

        $("[datepicker=date_retour_unique]").datepicker(jQuery.extend({}, options_Date,{
            onClose: function( selectedDate ) {
                $( "[datepicker=date_allet_unique]" ).datepicker( "option", "maxDate", selectedDate );
            }
        }));

}


$( document ).ready(function() {

    $("#wanasni_trajetbundle_trajet_round_trip").on("change", updateRoundTripChanged);

    updateRoundTripChanged();

    UniqueTrip();

    regularTrip.init();


    $("#wanasni_trajetbundle_trajet_informationsComplementaires").on("keyup keydown blur",function(){
        if ($(this).val().length > 500){
            $(this).val($(this).val().substr(0, 500));
        }

        $("#description-chars").html($(this).val().length);
    });




});



