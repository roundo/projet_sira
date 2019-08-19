<?php
require('inc/modele.php');

if(isset($_POST['pseudo'])){

	extract($_POST);//ça me permet d'avoir accès à $pseudo, $nom ...

	$logExist = execRequete("SELECT * FROM membre WHERE pseudo = :login", ["login" => $pseudo]);

	if( $logExist->rowCount() != 0 ){
		echo "<div class='text-center'> ce login existe déjà</div>";
	}else{
	
		$query = "INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement) 
		VALUES(:pseudo, :mdp, :nom, :prenom, :mail, :sexe, 0, Now() )"; 

		$res = execRequete($query, 
							array(
									"pseudo" => $pseudo, 
									"mdp"    => md5($mdp),
									"nom"    => $nom,
									"prenom" => $prenom,
									"mail"   => $mail,
									"sexe"   => $civilite,
								   ) );

		$_SESSION['erreur'] = "<h3 class='inscription'>Inscription réussie</h3>";
		header("location: ".RACINE_SITE);
	}

}
