<?php 

require('inc/modele.php');

if( !isConnected() ){

	$_SESSION['sendMessage'] = '<span class="text-danger">Connectez vous pour faire une location!!</span>';

	header('location:'.RACINE_SITE);
	exit();
}


if( isset($_GET['reservation']) ){

	$query = execRequete("SELECT v.*, a.id_agence 
						  from vehicule v, agences a 
						  WHERE id_vehicule = :idv 
						  AND v.id_agence = a.id_agence", 
						  array("idv" => $_GET['reservation']));

	$reservation = $query->fetch();
}


/* Cas réservation */
if( !empty($_POST['date_debut']) && $_POST['date_fin'] >= $_POST['date_debut'] ){



	extract($_POST);

	$prix_total = nbJour($date_debut, $date_fin) * $pttc;

	execRequete("INSERT INTO commande(id_membre, id_vehicule, id_agence, date_heure_depart, date_heure_fin, prix_total)
				  VALUES(:id_membre, :id_vehicule, :id_agence, :dd, :df, :pttc )",
				  array(
				 		"id_membre" => $id_membre,
				 		'id_vehicule' => $id_vehicule,
				 		'id_agence' => $id_agence,
				 		'dd' => $date_debut,
				 		'df' => $date_fin,
				 		'pttc' => $prix_total
				 ));

	$_SESSION['sendMessage'] = "<span class='text-success'>Réservation effectuée avec succès</span>";

	header('location:'.RACINE_SITE.'membre/compte.php');
	exit();
}

require('inc/header.php');
require('template/reservation.phtml');
require('inc/footer.php');
