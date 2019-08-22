"use strict";
/*********************************************************
********************  VARRIABLES *************************
**********************************************************/
var prixElt    = document.getElementById('prix');
var pttcElt    = document.getElementById('pttc').value;
var date_debut = document.getElementById('dd');
var date_fin   = document.getElementById('df');

var date_debut_saisie;

/*********************************************************
********************  EVENEMENTS *************************
**********************************************************/

date_debut.addEventListener('change', function(e){
	date_debut_saisie = e.target.value;

	date_fin.addEventListener('change', function(e){		

		var date_fin_saisie   = e.target.value;
		var date_debut_parse  = Date.parse(date_debut_saisie);
		var date_fin_parse 	  = Date.parse(date_fin_saisie);
	
		var nbJour            = ( date_fin_parse-date_debut_parse ) / 86400000;

		prixElt.innerHTML = "<strong id='prixx'>"+nbJour+" jours pour "+nbJour*pttcElt+" € </strong>";
	});
});


//<input id="text" type="text" size="60" value="Vous n'avez pas le focus !" />


    var text = document.getElementById('text');
  
    date_fin.addEventListener('focus', function(e) {
    	/*date_debut_saisie.setDate(date_debut_saisie.getDate()+1);
    	 */
       console.log(date_debut_saisie);
        var dd = new Date(date_debut_saisie);

        dd.setDate(dd.getDate()+1);

        e.target.min = dd;
        console.log(dd);
     //   e.target.dfElt.min = dd;//date_debut_saisie;
    });
   /* var date = new Date().toLocaleDateString();
    date.setDate(date.getDate()+1);
    console.log(date);*/

    /*text.addEventListener('blur', function(e) {
        e.target.value = "Vous n'avez pas le focus !";
    });*/
/*$(document).ready(function() { 
  $( "#dd" ).datepicker({ 
    defaultDate: "+1w", 
    numberOfMonths: 2, 
    changeMonth: true, 
    changeYear: true, 
    yearRange: '-1:+1', 
    maxDate: '+1Y', 
    onClose: function( selectedDate ) { 
    $( "#dd" ).datepicker( "option", "minDate", selectedDate ); 
    } 
  }); 
  $( "#date_fin" ).datepicker({ 
    defaultDate: "+1w", 
    numberOfMonths: 2, 
    changeMonth: true, 
    changeYear: true, 
    maxDate: '+2Y', 
    onClose: function( selectedDate ) { 
    $( "#date_debut" ).datepicker( "option", "maxDate", selectedDate ); 
    } 
  });     
});*/