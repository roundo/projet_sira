<?php 

require('../inc/modele.php');


const SUPPRESSION = "Suppression impossible! Cette agence possède des véhicules";

//si pas adminirateur, retour à l'accueil
if( !isAdmin() )
	header('location:'.RACINE_SITE);


//liste des agences en BD
$list_agence = execRequete("SELECT * FROM agences");
$agence = $list_agence->fetchAll();	



/*cas d'ajout*/
if( isset($_POST['titre']) ){

	extract($_POST);

	$nom_photo = '';

	//récuperation du nom de la photo actuelle en BD si pas de modif sur l'img
	if( isset($_POST['photo_actuelle']) )
		$nom_photo = $_POST['photo_actuelle'];


	//récuperation de la photo chargée pour insertion
	if( !empty($_FILES['photo']['name']) ){

		if($_FILES['photo']['size'] <= 1000000){

			$extension = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
			$info = pathinfo($_FILES['photo']['name']);
			$extension_up = $info['extension'];

			if(in_array($extension_up, $extension)){

				$dateEnrPhoto = Date("d_m_Y_h_i_s");
				$nom_photo = basename($_FILES['photo']['name']);
				$root = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE.'utilities/img';
				move_uploaded_file($_FILES['photo']['tmp_name'], $root.'/'.$nom_photo);
			}
		}
	}



	/*mise à jour si nouvel id d'agence*/
	if( !empty($_POST['id_agence']) ){
		var_dump($_POST);

		execRequete("UPDATE agences SET titre=:titre, adresse=:add, ville=:ville, cp=:cp, description=:descr, photo=:photo WHERE id_agence = :id_agence",
					array(	
							"titre" => $titre,
							"add" => $adresse,
							"ville" => $ville,
							"cp" => $cp,
							"descr" => $desc,
							"photo" => $nom_photo,
							"id_agence" => $id_agence
						));
	}else{
		/*insertion*/
		execRequete("REPLACE INTO agences 
								VALUES(:id_agence,:titre,:adresse,:ville,:cp,:descr,:photo )", 
								array(
										"id_agence" => $id_agence,
										"titre" => $titre,
										"adresse" => $adresse,
										"ville" => $ville,
										"cp" => $cp,
										"descr" => $desc,
										"photo" => $nom_photo
									));
	}

	header("location:".RACINE_SITE."admin/gestion_agence.php#ancre_filtre");
	exit();
}



/*Cas de modification */
if( isset($_GET['action']) && $_GET['action'] == 'modification' ){
	$res = execRequete( "SELECT * FROM agences WHERE id_agence = ?", 
						array($_GET['id']) );

	$agence_actuel = $res->fetch();
}



/* Cas suppression */
if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){

	//Récuperation de la photo si elle éxiste en bd
	$resultat = execRequete("SELECT * FROM agences WHERE id_agence = ?", 
							 array($_GET['id']));
	

	//suppression de l'enrégisttrement en BD
	$sup = execRequete("DELETE FROM agences WHERE id_agence = ?",
				 array($_GET['id']));

	//ensuite si la suppression reussit, on supprime la photo récupérée de notre dossier
	if( $resultat->rowCount() != 0 && $sup ){

		$agence = $resultat->fetch();
		$phot_a_supp = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE.'utilities/img/'.$agence['photo'];
		
		if( !empty($agence['photo']) && file_exists($phot_a_supp) ){
			unlink($phot_a_supp);
		}
	}

	header('location:'.RACINE_SITE.'admin/gestion_agence.php#ancre_filtre');
	exit();
}

require('../inc/header.php');
require('../template/gestion_agence.phtml');
require('../inc/footer.php');
?>
