/**
 * Created by Toshiba on 15-03-2016.
 */

var $round_trip_CheckBox=$("#wanasni_trajetbundle_trajetunique_round_trip");

if(!$round_trip_CheckBox.length){
    $round_trip_CheckBox=$("#wanasni_trajetbundle_trajetregulier_round_trip");
}



function updateRoundTripChanged() {
    if (true === $round_trip_CheckBox.is(":checked")) {
        $(".return-container").show()
    } else {
        $(".return-container").hide()
    }

    $round_trip_CheckBox.on("change",updateRoundTripChanged);

}




var regularTrip = function () {

    var self = {dates: {simple: {}, round: {}}}, that = {};



    self.load = function () {
        self.widgetCalendar = $("#regular-calendar");
        self.widgetChooseDate = $("#chooseDate");
        self.widgetDateStart = $("#wanasni_trajetbundle_trajetregulier_regular_begin_date");
        self.widgetDateStop = $("#wanasni_trajetbundle_trajetregulier_regular_end_date");
        self.widgetRoundTrip = $("#wanasni_trajetbundle_trajetregulier_round_trip");

        /*
        self.widgetCalendarAll = $("#all-calendars");
        self.widgetAllModal = $("#seeAll");
        self.isEdition = $("#is_edition").val() == 1;
        self.isBackFromNextStep = $("#is_back").val() == 1;
        self.hasErrors = $("#has_errors").val() == 1;
*/
    };

    self.hasDate = function (typeDate, dateKey) {
        var dates = typeDate === "simple" ? self.dates.simple : self.dates.round;
        return dates[dateKey] ? true : false
    };

    self.getDateKey = function (date) {
        return $.datepicker.formatDate("yymmdd", date)
    };

    self.getReverseDateKey = function (dateKey) {
        return new Date(dateKey.substr(0, 4), parseInt(dateKey.substr(4, 2), 10) - 1, dateKey.substr(6, 2))
    };

    self.addDateToForm = function (collectionId, dateKey) {
        if ($(collectionId + " input[value=" + dateKey + "]").length > 0) {
            return
        }
        var prototype = $(collectionId).data("prototype");
        var newItem = prototype.replace(/__name__/g, dateKey);
        $(collectionId).append(newItem);
        $(collectionId + "_" + dateKey).attr("value", dateKey)
    };

    self.addRemoveDate = function (action, typeTrip, dateTrip) {
        var dateKey = self.getDateKey(dateTrip);
        var regularId = {simple:"#wanasni_trajetbundle_trajetregulier_datesAller", round:"#wanasni_trajetbundle_trajetregulier_datesRetour"};
        if (action === "add") {
            self.dates[typeTrip][dateKey] = dateTrip;
            self.addDateToForm(regularId[typeTrip], dateKey)
        } else {
            delete self.dates[typeTrip][dateKey];
            $(regularId[typeTrip] + " input[value=" + dateKey + "]").parent().remove()
        }
    };


    self.updateDateStart = function () {
        var dateStart = self.widgetDateStart.datepicker("getDate");
        self.widgetCalendar.datepicker("option", "minDate", dateStart);
        self.widgetCalendar.datepicker("option", "setDate", dateStart);

        self.widgetDateStop.datepicker("option", "minDate", dateStart);
        self.widgetDateStop.datepicker("option", "setDate", dateStart);

        //self.widgetCalendarAll.datepicker("option", "minDate", dateStart);
        if (self.dateStartPrevious < dateStart) {
            while (self.dateStartPrevious < dateStart) {
                self.addRemoveDate("remove", "simple", self.dateStartPrevious);
                self.addRemoveDate("remove", "round", self.dateStartPrevious);
                self.dateStartPrevious.setDate(self.dateStartPrevious.getDate() + 1)
            }
        } else {
            self.dateStartPrevious = new Date(dateStart.getTime())
        }
        //self.updateDays();
        self.widgetCalendar.datepicker("refresh")
    };

    self.updateDateStop = function () {
        var dateStop = self.widgetDateStop.datepicker("getDate");
        self.widgetCalendar.datepicker("option", "maxDate", dateStop);
        self.widgetDateStart.datepicker("option", "maxDate", dateStop);
        //self.widgetCalendarAll.datepicker("option", "maxDate", dateStop);
        if (self.dateStopPrevious > dateStop) {
            while (self.dateStopPrevious > dateStop) {
                self.addRemoveDate("remove", "simple", self.dateStopPrevious);
                self.addRemoveDate("remove", "round", self.dateStopPrevious);
                self.dateStopPrevious.setDate(self.dateStopPrevious.getDate() - 1)
            }
        } else {
            self.dateStopPrevious = new Date(dateStop.getTime())
        }
        //self.updateDays();
        self.widgetCalendar.datepicker("refresh")
    };


    self.beforeShowDay = function (date) {
        var dateCalendarKey = self.getDateKey(date), dateCalendarClass = "";
        if (self.hasDate("simple", dateCalendarKey)) {
            dateCalendarClass += "simple-date-selected"
        }
        if (self.hasDate("round", dateCalendarKey)) {
            dateCalendarClass += " round-date-selected"
        }
        return [true, dateCalendarClass]
    };

    self.uncheckDays = function (type) {
        $.each(self.dates[type], function (k, v) {
            self.addRemoveDate("remove", type, self.getReverseDateKey(k))
        });

        self.widgetCalendar.datepicker("refresh")
    };





    that.init = function () {

        self.load();
        self.initialEndDate = self.widgetDateStop.datepicker("getDate");
        var optionsCalendar = {
            selectOtherMonths: true,
            showAnim: "",
            dateFormat: self.widgetCalendar.attr("data-date-format"),
            firstDay: "1"
        };
        self.widgetDateStart.datepicker(optionsCalendar);
        self.widgetDateStart.datepicker("setDate", new Date());
        self.widgetDateStart.datepicker("option", "onSelect", self.updateDateStart);
        self.widgetDateStart.on("change", self.updateDateStart);
        self.widgetDateStop.datepicker(optionsCalendar);
        self.widgetDateStop.datepicker("setDate", "3m" );
        self.widgetDateStop.datepicker("option", "onSelect", self.updateDateStop);
        self.widgetDateStop.on("change", self.updateDateStop);

        if (self.widgetDateStart.length) {
            self.dateStartPrevious = new Date(self.widgetDateStart.datepicker("getDate").getTime());
            self.dateStopPrevious = new Date(self.widgetDateStop.datepicker("getDate").getTime())
        }


        self.widgetCalendar.datepicker(jQuery.extend({}, optionsCalendar, {
            defaultDate: self.widgetDateStart.datepicker("getDate"),
            minDate: self.widgetDateStart.datepicker("getDate"),
            maxDate: self.widgetDateStop.datepicker("getDate"),
            beforeShowDay: self.beforeShowDay,
            onSelect: function () {
                var dayCalendar = self.getDateKey(self.widgetCalendar.datepicker("getDate"));
                if ( self.widgetRoundTrip.is(":checked") ) {
                    self.widgetChooseDate.attr("data-day", dayCalendar);
                    self.widgetChooseDate.modal('show');
                    if (self.hasDate("simple", dayCalendar)) {
                        $("input#simple-choice").attr("checked", "checked");
                        $(".simple-choice-label").addClass("label-success")
                    }
                    if (self.hasDate("round", dayCalendar)) {
                        $("input#round-choice").attr("checked", "checked");
                        $(".round-choice-label").addClass("label-info")
                    }
                } else {
                    var dayCalendarSimple = self.getReverseDateKey(dayCalendar);
                    if (self.hasDate("simple", dayCalendar)) {
                        self.addRemoveDate("remove", "simple", dayCalendarSimple)
                    } else {
                        self.addRemoveDate("add", "simple", dayCalendarSimple)
                    }
                }
            }
        }));



        self.widgetChooseDate.find("button.btn-validation").click(function () {
            var dayModal = self.getReverseDateKey(self.widgetChooseDate.attr("data-day")), checkBoxSimple = self.widgetChooseDate.find("input#simple-choice"), checkBoxRound = self.widgetChooseDate.find("input#round-choice");
            var simpleAction = checkBoxSimple.is(":checked") ? "add" : "remove";
            self.addRemoveDate(simpleAction, "simple", dayModal);
            var roundAction = checkBoxRound.is(":checked") ? "add" : "remove";
            self.addRemoveDate(roundAction, "round", dayModal);
            self.beforeShowDay(dayModal);
            self.widgetCalendar.datepicker("refresh");
            checkBoxSimple.attr("checked", false);
            $(".simple-choice-label").removeClass("label-success");
            checkBoxRound.attr("checked", false);
            $(".round-choice-label").removeClass("label-info")
        });

        self.widgetRoundTrip.on("change", function () {
            if (false == self.widgetRoundTrip.is(":checked")) {
                self.uncheckDays("round")
            }
        });


    };

    return that;

}();//Regular function

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

function info_Complementaire(){

    var description=$("#wanasni_trajetbundle_trajetunique_informationsComplementaires");
    if(!description.length){
        description=$("#wanasni_trajetbundle_trajetregulier_informationsComplementaires");
    }

    description.on("keyup keydown blur",function(){
        if($(this).val().length > 500){
            $(this).val($(this).val().substr(0, 500))
        }
        $("#description-chars").html($(this).val().length);
    });
}


$( document ).ready(function() {




    updateRoundTripChanged();

    UniqueTrip();

    regularTrip.init();

    info_Complementaire()


});



