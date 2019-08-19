<?php
require('inc/modele.php');

if( isset($_GET['action']) ){
	session_destroy();	
	header('location:'. RACINE_SITE);
	exit();
}


if( isset($_POST['mdp']) && isset($_POST['pseudo']) ){
	$con = execRequete("SELECT * FROM membre WHERE pseudo = ? AND mdp = ?", [$_POST['pseudo'], md5( $_POST['mdp'] )]);

	if( $con->rowCount() != 0 ){
		$res = $con->fetch();
		$_SESSION['membre'] = $res;
		
	}else{
		$_SESSION['erreur'] = "<h3 class='erreurLog'>Identifiants incorrects ou utilisateur inexistant</h3>";
	}
	header("location: ".RACINE_SITE);
}
