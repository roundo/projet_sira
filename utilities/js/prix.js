"use strict";
/*********************************************************
********************  VARRIABLES *************************
**********************************************************/
var prixElt    = document.getElementById('prix');
var pttcElt    = document.getElementById('pttc').value;
var date_debut = document.getElementById('date_debut');
var date_fin   = document.getElementById('date_fin');

/*********************************************************
********************  EVENEMENTS *************************
**********************************************************/

date_debut.addEventListener('change', function(e){

	date_fin.disabled = false;		
	
	date_fin.addEventListener('change', function(e){

		var nbJour        = ( Date.parse(date_fin.value)-Date.parse(date_debut.value) ) / 86400000+1;

		prixElt.innerHTML = "<strong id='prixx'>"+nbJour+" jours pour "+nbJour*pttcElt+" € </strong>";
	});
});
 


date_fin.addEventListener('focus', function(e) {

  	var dd = new Date(date_debut.value);
  	dd.setDate( dd.getDate() + 15 );

    e.target.min = date_debut.value;
    e.target.max = dd.toJSON().substring(0, 10); 
}); 









//autre solution

/************************************
************ VARIABLES **************
************************************/
/*var date_debut = document.getElementById('date_debut');
var date_fin   = document.getElementById('date_fin');
var prix       = document.getElementById('prix').innerHTML;
var prix_ttc   = document.getElementsByClassName('prix_ttc');
*/

/************************************
************ FONCTIONS **************
************************************/
/*date_debut.addEventListener('change', function(){
	//je réactive l'input date de fin
	date_fin.disabled = false;

	date_fin.min = date_debut.value;

	date_fin.addEventListener('change', function(){

		var jours = nbJour(date_debut.value, date_fin.value);

		prix_ttc[0].innerHTML = jours +" jours pour " + prix*jours+" €";
	});

});

date_fin.addEventListener('focus', function(){

	var dateMax = new Date(date_debut.value);

	dateMax.setDate( dateMax.getDate()+10 );
	var d = dateMax.toJSON();
	date_fin.max = d.substring(0, 10);


});*/

//calcule le nombre de jours
/*function nbJour(d1, d2){
	var date1 = new Date(d1);
	var date2 = new Date(d2);

	return (date2-date1)/86400000+1;
}
*/