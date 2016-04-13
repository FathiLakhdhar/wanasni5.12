/*
ADD+Remove Ville Etape
 */


function updateWaypointsIndices() {
    var i = 0;
    $(".waypoint-list li.point").each(function () {

        $(this).find("input").each(function () {
            var id = $(this).attr("id");
            var name = $(this).attr("name");
            $(this).attr("id", id.replace(/waypoints_\d+_/, "waypoints_" + i + "_"));
            $(this).attr("name", name.replace(/\[waypoints\]\[\d+\]/, "[waypoints][" + i + "]"))
        });

        i++
    })
}

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient
    // l'attribut « data-prototype » qui nous intéresse.

    var $container = $('#wanasni_trajetbundle_trajetunique_waypoints');

    if (!$container.length){
         $container = $('#wanasni_trajetbundle_trajetregulier_waypoints');
    }


    // On ajoute un lien pour ajouter une nouvelle Waypoint
    var $lienAjout = $('<a href="#" id="ajout_waypoint" class="btn btn-green">Ajouter un Lieu</a>');
    $container.prepend($lienAjout);

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $lienAjout.click(function(e) {
        ajouterWaypoint($container);
        e.preventDefault();
        return false;
    });

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find('li').length;

    // On ajoute un premier champ directement s'il n'en existe pas déjà un (cas d'un nouvel Trajet par exemple).
    if (index == 0) {
        ajouterWaypoint($container);
    }  else {
        // Pour chaque Waypoint déjà existante, on ajoute un lien de suppression
        $container.children('li.point').each(function() {
            ajouterLienSuppression($(this));
        });
    }

    // La fonction qui ajoute un formulaire Waypoints
    function ajouterWaypoint($container) {

        var $prototype = $($container.attr('data-prototype')
            .replace(/__name__label__/g, index)
            .replace(/__name__/g, index)
        );


        // On ajoute au prototype un lien pour pouvoir supprimer la Waypoint
        ajouterLienSuppression($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);


        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;


        var elemID =$prototype.find('input[inputAutoComplete=on]').attr('id');
        document.getElementById(elemID).addEventListener('focusin',function() {
            AutoComplete($(this).attr('id'));
        });

    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function ajouterLienSuppression($prototype) {
        $lienSuppression = $('<a href="#" class="close" title="Enlever l\'étape"><i class="fa fa-close"></i></a>');
        // Ajout du lien
        $prototype.find('div.waypoint').append($lienSuppression);
        // Ajout du listener sur le clic du lien
        $lienSuppression.click(function(e) {
            $prototype.remove();
            e.preventDefault();// évite qu'un # apparaisse dans l'URL
            calculateAndDisplayRoute(directionsService,directionsDisplay);

            updateWaypointsIndices();
            return false;
        });

    }

});