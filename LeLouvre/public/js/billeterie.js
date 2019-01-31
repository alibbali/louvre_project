$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
let $container = $('#reservation_billets');
        
// On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
let index = $container.find(':input').length;

let compteur = $('#compteur');
let recap = $('#recap');
recap.hide();
// On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
$('#ajouter').click(function(e) {
  if(compteur.val() <= 0) {
      $('#ajouter').show();
  }
  else {
      $('#recap').show();
      $('#ajouter').hide();
  }
let nbBillets = compteur.val();
for(let i = 0; i < nbBillets ; i ++){
    addReservation($container);
}
e.preventDefault(); // évite qu'un # apparaisse dans l'URL

return false;
});

function addReservation($container) {
var template = $container.attr('data-prototype')
  .replace(/__name__label__/g, 'Billet n°' + (index+1))
  .replace(/__name__/g, index)
;

var $prototype = $(template);
$container.append($prototype);
index++;
}
});
