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
		$_SESSION['sendMessage'] = "<span class='text-success'>Bienvenue ".$_SESSION['membre']['prenom']."</span>";
	}else{
		$_SESSION['sendMessage'] = "<span class='text-danger'>Identifiants incorrects ou utilisateur inexistant</span>";
	}

	header("location: ".RACINE_SITE);
	exit();
}
