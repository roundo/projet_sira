<?php 

require('../inc/modele.php');

const SUPPRESSION = "Suppression impossible! Ce véhicule est en location ou déjà commandé !";


if( !isAdmin() )
	header('location:'.RACINE_SITE);


$list_vehicule = execRequete("SELECT v.*, a.titre t_agence, a.ville 
						      FROM vehicule v, agences a 
						      WHERE v.id_agence = a.id_agence");



/*liste de véhicules fitrés par agence*/
if( isset($_GET['action']) && $_GET['action'] == 'filtre_agence' ){
	$list_vehicule = execRequete("SELECT v.*, a.titre t_agence, a.ville 
								  FROM vehicule v, agences a 
								  WHERE v.id_agence = a.id_agence
								  AND a.id_agence = :filtre_agence",
								  array('filtre_agence' => $_GET['id_agence']));
}

$vehicule = $list_vehicule->fetchAll();	



/*cas d'ajout*/
if( isset($_POST['id_vehicule']) ){

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
				$nom_photo = $dateEnrPhoto.'_'. basename($_FILES['photo']['name']);
				$root = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE.'utilities/img';
				move_uploaded_file($_FILES['photo']['tmp_name'], $root.'/'.$nom_photo);
			}
		}
	}	

	/*mise à jour si nouvel id de véhicule*/
	if( !empty($_POST['id_vehicule']) ){

		execRequete("UPDATE vehicule 
					 SET id_agence=:id_agence, titre=:titre, marque=:marque, modele=:modele, description=:descr, photo=:photo, prix_journalier=:prix 
					 WHERE id_vehicule = :id_vehicule",
					 array(	
					 		"id_agence" => $id_agence, 
							"titre" => $titre,
							"marque" => $marque,
							"modele" => $modele,
							"descr" => $desc,
							"photo" => $nom_photo,
							"prix" => $prix,
							"id_vehicule" => $id_vehicule
						));
	}else{/*insertion*/
		execRequete("REPLACE INTO vehicule 
								VALUES(:id_vehicule,:id_agence,:titre,:marque,:modele,:descr,:photo,:prix )", 
								array(
										"id_vehicule" => $id_vehicule,
										"id_agence" => (int)$id_agence,
										"titre" => $titre,
										"marque" => $marque,
										"modele" => $modele,
										"descr" => $desc,
										"photo" => $nom_photo,
										"prix" => $prix
									));
	}

	header("location:".RACINE_SITE."admin/gestion_vehicule.php");
	exit();
}


/*Cas de modification */
if( isset($_GET['action']) && $_GET['action'] == 'modification' ){

	$res = execRequete( "SELECT * FROM vehicule WHERE id_vehicule = ?", 
						array($_GET['id']) );

	$vehicule_actuel = $res->fetch();
}


/* Cas suppression */
if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){

	//Récuperation de la photo si elle éxiste en BD
	$resultat = execRequete("SELECT * FROM vehicule WHERE id_vehicule = ?", 
							 array($_GET['id']));
	

	//suppression de l'enrégisttrement en BD
	$sup = execRequete("DELETE FROM vehicule WHERE id_vehicule = ?",
				 array($_GET['id']));

	//ensuite si la suppression reussit, on supprime la photo récupérée de notre dossier
	if( $resultat->rowCount() != 0 && $sup ){

		$vehicul = $resultat->fetch();
		$phot_a_supp = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE.'utilities/img/'.$vehicul['photo'];

		if( !empty($vehicul['photo']) && file_exists($phot_a_supp) ){
			unlink($phot_a_supp);
		}
	}

	header('location:'.RACINE_SITE.'admin/gestion_vehicule.php');
	exit();
}


 require('../inc/header.php');
 require('../template/gestion_vehicule.phtml');
 require('../inc/footer.php');


