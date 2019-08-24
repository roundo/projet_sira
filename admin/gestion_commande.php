<?php

require('../inc/modele.php');

if( !isConnected() )
	header('location:'.RACINE_SITE);

$numLoc = 1;

//liste de toutes les commandes
$query = execRequete("SELECT * 
					  FROM commande c, vehicule v, agences a, membre m 
					  WHERE c.id_vehicule = v.id_vehicule 
					  AND c.id_agence = a.id_agence
					  AND m.id_membre = c.id_membre"
					  );


//fitre des commandes par agence
if( isset($_GET['action']) && $_GET['action'] == 'filtre_commande' ){
	$query = execRequete("SELECT * 
					  FROM commande c, vehicule v, agences a, membre m 
					  WHERE c.id_vehicule = v.id_vehicule 
					  AND c.id_agence = a.id_agence
					  AND m.id_membre = c.id_membre
					  AND a.id_agence = :agence",
					  array("agence" => $_GET['agence'])
					  );
}

$historique_loca = $query->fetchAll();


require('../inc/header.php');
require('../template/gestion_commande.phtml');
require('../inc/footer.php');