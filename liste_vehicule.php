

<?php

	require_once('inc/modele.php');
 
	$vehicules = execRequete("SELECT v.*, a.titre as titreagence
                            FROM vehicule v
                            INNER JOIN agences a
                            ON v.id_agence = a.id_agence
                            ORDER BY v.titre DESC");

  if( isset($_GET['action']) && $_GET['action'] == 'croissant' ){
    $vehicules = execRequete("SELECT v.*, a.titre as titreagence
                            FROM vehicule v
                            INNER JOIN agences a
                            ON v.id_agence = a.id_agence
                            ORDER BY v.prix_journalier ASC");

  }
  if( isset($_GET['action']) && $_GET['action'] == 'decroissant' ){
    $vehicules = execRequete("SELECT v.*, a.titre as titreagence
                            FROM vehicule v
                            INNER JOIN agences a
                            ON v.id_agence = a.id_agence
                            ORDER BY v.prix_journalier DESC");

  }

              //INNER JOIN commande c  ON c.id_vehicule = c.id_vehicule  GROUP BY v.id_vehicule


  require('template/liste_vehicule.phtml');