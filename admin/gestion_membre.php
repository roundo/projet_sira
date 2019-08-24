<?php
require('../inc/modele.php');

const SUPPRESSION = "Suppression impossible! Ce membre a au moins une commande !";

if( !isAdmin() ){
	header("location:".RACINE_SITE);
	exit();
}

$membres = execRequete("SELECT * FROM membre");
//$membres = $membres->fetchAll();

/*Cas de suppression*/
if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){
	execRequete("DELETE FROM membre WHERE id_membre = ?", array($_GET['id']));

	header("location:".RACINE_SITE."admin/gestion_membre.php");
	exit();
}

/*Cas de modification*/
if( isset($_GET['action']) && $_GET['action'] == 'modification' && isset($_GET['id'])){
	$membre_actuel = execRequete("SELECT * FROM membre WHERE id_membre = ?", array($_GET['id']));

	$membre_actuel = $membre_actuel->fetch();
	//header("location:".RACINE_SITE."admin/gestion_membre.php");
}

// Cas Ajout/Modification
if( isset($_POST['pseudo']) ){
	extract($_POST);
	if( !empty($_POST['id_membre']) ){
		var_dump($_POST);

		execRequete( "UPDATE membre 
					  SET pseudo=:pseudo, mdp=:mdp, nom=:nom, prenom=:prenom, email=:mail, civilite=:sexe, statut=:statut 
					  WHERE id_membre=:id_membre", 
					  array( 
					  		"pseudo" => $pseudo,
					  		"mdp" => $mdp,
					  		"nom" => $nom,
					  		"prenom" => $prenom,
					  		"mail" => $mail,
					  		"sexe" => $civilite,
					  		"statut" => $statut,
					  		"id_membre" => $id_membre 
					  	));

	}else{
		execRequete("REPLACE INTO membre 
					VALUES(:id_membre, :pseudo,:mdp,:nom, :prenom,:mail,:sexe,:statut, Now() )",
					array(
						"id_membre" => $id_membre,
						"pseudo" => $pseudo,
						"mdp" => md5( $mdp ),
						"nom" => $nom,
						"prenom" => $prenom,
						"mail" => $mail,
						"sexe" => $civilite,
						"statut" => $statut
					));
	}

	header("location:".RACINE_SITE."admin/gestion_membre.php");
	exit();
}

require('../inc/header.php');
require('../template/gestion_membre.phtml');
require('../inc/footer.php');