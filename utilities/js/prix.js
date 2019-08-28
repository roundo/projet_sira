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

		/*var date_debut_parse  = Date.parse(date_debut.value);
		var date_fin_parse 	  = Date.parse(date_fin.value);*/

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
