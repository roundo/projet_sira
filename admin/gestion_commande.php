<?php
require('../inc/modele.php');

if( !isConnected() )
	header('location:'.RACINE_SITE);

$numLoc = 1;

$query = execRequete("SELECT * 
					  FROM commande c, vehicule v, agences a, membre m 
					  WHERE c.id_vehicule = v.id_vehicule 
					  AND c.id_agence = a.id_agence
					  AND m.id_membre = c.id_membre"
					  );

$historique_loca = $query->fetchAll();

require('../inc/header.php');
require('../template/gestion_commande.phtml');
require('../inc/footer.php');