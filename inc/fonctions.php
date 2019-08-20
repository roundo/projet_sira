<?php

function execRequete($req, $params = array()){
	global $pdo;//globalisation de la variable pdo

	try{
		$res = $pdo->prepare($req);

		if(!empty($params) ){
			foreach ($params as $key => $value) {
				$params[$key] = htmlspecialchars($value);
			}
		}

		$res->execute($params);
		if( !$res ){
			$error = "Suppression impossible";
		   $_SESSION['err'] = $error;
			throw new Exception($error);
		}else
			return $res;
	}catch(PDOException $e){
		$_SESSION['err'] = "sup imp"; 
		echo $e->getMessage();
	}
}

function isConnected(){
	if(isset($_SESSION['membre']))
		return true;
	return false;
}

function isAdmin(){
	if( isConnected() && $_SESSION['membre']['statut'] == 1 )
		return true;
	return false;
}

function nbJour( $date_debut, $date_fin ){

	// On transforme les 2 dates en timestamp
	$date_d = strtotime($date_debut);
	$date_f = strtotime($date_fin);
	 
	// On récupère la différence de timestamp entre les 2 précédents
	$nbJoursTimestamp = $date_f - $date_d;

	// ** Pour convertir le timestamp (exprimé en secondes) en jours **
	// On sait que 1 heure = 60 secondes * 60 minutes et que 1 jour = 24 heures donc :
	$nbJours = $nbJoursTimestamp/86400; // 86 400 = 60*60*24
	 
	return $nbJours;
}

function encours( $df ){
	$date_actuelle = date('Y-m-d');

	if( $date_actuelle > $df )
		return "<span>Terminée</span>";

	return "<span>En cours</span>";
}

function enLocation( $id_vehicule_loue ){
	$date = date('Y-m-d');
$location = execRequete("SELECT DISTINCT $id_vehicule_loue 			FROM commande 
									 WHERE id_vehicule = :id 
									 AND date_heure_fin > :dt", 
									 array("id" => $id_vehicule_loue, 
													 			"dt" => $date));
													 			
  if( $location->rowCount() != 0 )
  	return true;
  return false;	
}