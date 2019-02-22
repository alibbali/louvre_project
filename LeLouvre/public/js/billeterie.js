$(function() {
    let container = $('#reservation_billets');
    let reservation = $('#reservation_save');
    //Définition d'un numéro de billet pour chaque entrée
    let index = container.find(':input').length;

    //Si index inférieur ou égal à 0 alors on n'affiche pas le bouton commander pour éviter les erreurs
    $('#add_category').click(function (e) {
        addBillets(container); 

        e.preventDefault();
        return false;
    });

    //Ajout d'un premier billet si il n'en existe pas.
    if(index == 0) {
        addBillets(container);
    }
    else {
        container.children('div').each(function(){
            addDeleteLink($(this));
        })
    }




    //Function addBillets

    function addBillets($container ) {
        let template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Billets n°' + (index+1))
            .replace(/__name__/g, index);

        let prototype = $(template);
        addDeleteLink(prototype);
        $container.append(prototype);
        index ++;
    }

    function addDeleteLink($prototype) {

        let button = $('<a href="#" class="btn btn-warning">Supprimer ce billet</a>');

        $prototype.append(button);

        button.click(function(e){
            $prototype.remove();
            index --;
            e.preventDefault();
            return false;
        })
    }
});