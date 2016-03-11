/*
ADD+Remove Ville Etape
 */

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient
    // l'attribut « data-prototype » qui nous intéresse.

    var $container = $('div#wanasni_trajetbundle_trajet_waypoints');

    // On ajoute un lien pour ajouter une nouvelle Waypoint
    var $lienAjout = $('<a href="#" id="ajout_waypoint" class="btn btn-green">Ajouter un Lieu</a>');
    $container.append($lienAjout);

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $lienAjout.click(function(e) {
        ajouterWaypoint($container);
        e.preventDefault();// évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // On ajoute un premier champ directement s'il n'en existe pas déjà un (cas d'un nouvel Trajet par exemple).
    if (index == 0) {
        ajouterWaypoint($container);
    }  else {
        // Pour chaque Waypoint déjà existante, on ajoute un lien de suppression
        $container.children('div').each(function() {
            ajouterLienSuppression($(this));
        });
    }

    // La fonction qui ajoute un formulaire Waypoints
    function ajouterWaypoint($container) {
            // Dans le contenu de l'attribut « data-prototype », on remplace :
            // - le texte "__name__label__" qu'il contient par le label du champ
            // - le texte "__name__" qu'il contient par le numéro du champ
        var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Villes étapes n°' + (index+1))
                                                            .replace(/__name__/g, index));

        $prototype.find('label').addClass('sr-only');

        var $id= 'wanasni_trajetbundle_trajet_waypoints_'+index+'_lieu';

        $marker = $('<span class="glyphicon glyphicon-map-marker yellow-dark"></span>');

        $prototype.first('div').addClass('form-group');

        $prototype.children('div').addClass('waypoint');
        $prototype.find('input[type=text]')
            .before($marker)
            .addClass('form-waypoint-lieu form-control text-indent')
            .attr('placeholder','Ville étape')
            .attr('onfocus',"AutoComplete('"+$id+"')")
        ;

        // On ajoute au prototype un lien pour pouvoir supprimer la Waypoint
        ajouterLienSuppression($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;

    }


    // La fonction qui ajoute un lien de suppression d'une catégorie
    function ajouterLienSuppression($prototype) {
        // Création du lien  <a class="close" href="#" title="Enlever l'étape">×</a>
        $lienSuppression = $('<a href="#" class="close" title="Enlever l\'étape"><i class="fa fa-close"></i></a>');
        // Ajout du lien
        $prototype.children('div').append($lienSuppression);
        // Ajout du listener sur le clic du lien
        $lienSuppression.click(function(e) {
            $prototype.remove();
            e.preventDefault();// évite qu'un # apparaisse dans l'URL
            return false;
        });

    }

});