"use strict";
/*********************************************************
********************  VARRIABLES *************************
**********************************************************/
var prixElt = document.getElementById('prix');
var pttcElt = document.getElementById('pttc').value;
var ddElt   = document.getElementById('dd');
var dfElt   = document.getElementById('df');

/*********************************************************
********************  EVENEMENTS *************************
**********************************************************/

ddElt.addEventListener('change', function(e){
	var dd = e.target.value;

	dfElt.addEventListener('change', function(e){		

		var df     = e.target.value;
		var dt 		 = Date.parse(dd);
		var ft 		 = Date.parse(df);
		var nbJour = (ft-dt)/86400000;

		prixElt.innerHTML = "<strong id='prixx'>"+nbJour+" jours pour "+nbJour*pttcElt+" € </strong>";
	});
});
