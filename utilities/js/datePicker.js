
/************************************
************ VARIABLES **************
************************************/
var date_debut = document.getElementById('date_debut');
var date_fin   = document.getElementById('date_fin');
var prix       = document.getElementById('prix').innerHTML;
var prix_ttc   = document.getElementsByClassName('prix_ttc');


/************************************
************ FONCTIONS **************
************************************/
date_debut.addEventListener('change', function(){
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


});

//calcule le nombre de jours
function nbJour(d1, d2){
	var date1 = new Date(d1);
	var date2 = new Date(d2);

	return (date2-date1)/86400000+1;
}
