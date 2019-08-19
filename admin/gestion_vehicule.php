<?php 
require('../inc/modele.php');

if( !isAdmin() )
	header('location:'.RACINE_SITE);

$list_vehicule = execRequete("SELECT v.*, a.titre t_agence FROM vehicule v, agences a WHERE v.id_agence = a.id_agence");
$vehicule = $list_vehicule->fetchAll();	

/*cas d'ajout*/
if( isset($_POST['titre']) && isset($_POST['marque']) ){

	extract($_POST);

	$nom_photo = '';

	if( isset($_POST['photo_actuelle']) )
		$nom_photo = $_POST['photo_actuelle'];

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
	header("location:".RACINE_SITE."admin/gestion_vehicule.php");
}

/*Cas de modification */
if( isset($_GET['action']) && $_GET['action'] == 'modification' ){
	$res = execRequete( "SELECT * FROM vehicule WHERE id_vehicule = ?", 
						array($_GET['id']) );
	$vehicule_actuel = $res->fetch();
}

/* Cas suppression */
if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){
	//suppression de la photo si elle éxiste
	$resultat = execRequete("SELECT * FROM vehicule WHERE id_vehicule = ?", 
							 array($_GET['id']));
	if( $resultat->rowCount() != 0 ){
		$agence = $resultat->fetch();
		$phot_a_supp = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE.'utilities/img/'.$agence['photo'];
		if( !empty($agence['photo']) && file_exists($phot_a_supp) ){
			unlink($phot_a_supp);
		}
	}

	//suppression de l'enrégisttrement en BD
	execRequete("DELETE FROM vehicule WHERE id_vehicule = ?",
				 array($_GET['id']));

	header('location:'.RACINE_SITE.'admin/gestion_vehicule.php');
	exit();
}

?>



 <?php require('../inc/header.php'); ?>

<div class="container">
	<h3 class="titre">Gestion des Véhicules</h3>
 	<table class="table table-bordered table-striped">
 		<tr>
 			<th>Véhicules</th>
 			<th>Agence</th>
 			<th>Titre</th>
 			<th>Marque</th>
 			<th>Modèle</th>
 			<th>Description</th>
 			<th>Photo</th>
 			<th>Prix</th>
 			<th>Actions</th>
 		</tr>
 		<?php foreach ($vehicule as $key => $valeur): ?>
 			<tr>
 				<td><?= $valeur['id_vehicule']; ?></td>
 				<td><?= $valeur['t_agence']; ?></td>
 				<td><?= $valeur['titre']; ?></td>
 				<td><?= $valeur['marque']; ?></td>
 				<td><?= $valeur['modele']; ?></td>
 				<td><?= $valeur['description']; ?></td>
 				<td>
 					<img class="img_tab" src="<?= RACINE_SITE.'/utilities/img/'. $valeur['photo']; ?>">
 				</td>
 				<td><?= $valeur['prix_journalier']; ?></td>
 				<td>
				<a href="?action=modification&id=<?= $valeur['id_vehicule'] ?>"><i class="fas fa-pen"></i>
				</a> 
				- 
				<a href="?action=suppression&id=<?= $valeur['id_vehicule'] ?>"><i class="fas fa-trash-alt"></i>
				</a> 
			</td>
 			</tr>
 		<?php endforeach; ?>
 	</table>
 	<hr>
 	<!-- Fomulaire gestion véhicule -->
 	<h4 class="titre">Ajout/Modif d'un véhicule</h4>
 	<form class="formulaire" method="post" action="" enctype="multipart/form-data">
 		<input type="hidden" name="id_vehicule" value="<?= $vehicule_actuel['id_vehicule'] ?? 0 ?>">
 		<div class="row">
 			<div class="form-group col-12">
 				<label>Agence</label>
 				<div class="input-group">
 					<select class="form-control" name="id_agence">
 						<?php $agence = execRequete("SELECT * FROM agences");
 						while ( $titreagence = $agence->fetch() ): ?>
 							<option value="<?= $titreagence['id_agence']; ?>"<?= isset($vehicule_actuel['id_agence']) && $vehicule_actuel['id_agence'] == $titreagence['id_agence'] ? 'selected' : '' ?>>
 								<?= $titreagence['titre']; ?>
 							</option>
 						<?php endwhile; ?>
 					</select>
 				</div>
 			</div>
 		</div>
 		<div class="row">
 			<div class="form-group col-6">
 				<label>Titre</label>
 				<div class="input-group">
 					<input type="text" name="titre" placeholder="Titre de l'annonce" class="form-control" value="<?= $vehicule_actuel['titre'] ?? '' ?>">
 				</div>
 			</div>
 			<div class="form-group col-6">
 				<label>Marque</label>
 				<div class="input-group">
 					<input type="text" name="marque" placeholder="Marque" class="form-control" value="<?= $vehicule_actuel['marque'] ?? '' ?>">
 				</div>
 			</div>
 		</div>
 		<div class="row">
 			<div class="form-group col-6">
 				<label>Description</label>
 				<div class="input-group">
 					<textarea name="desc" placeholder="Description de l'annonce" class="form-control"><?= $vehicule_actuel['description'] ?? '' ?></textarea>
 				</div>
 			</div>
 			<div class="form-group col-6">
 				<label>Modèle</label>
 				<div class="input-group">
 					<input type="text" name="modele" placeholder="Modèle" class="form-control" value="<?= $vehicule_actuel['modele'] ?? '' ?>">
 				</div>
 			</div>
 		</div>
 		<div class="row">
 			<div class="form-group col-6">
 				<label>Photo</label>
 				<div class="input-group">
 					<input type="file" name="photo" class="form-control" value="<?= $vehicule_actuel['photo'] ?? '' ?>">
 				</div>
 				<?php if( !empty($vehicule_actuel['photo']) ) :?>
 					<img class="img_tab" src="<?= RACINE_SITE . 'utilities/img/'.$vehicule_actuel['photo'] ?>">
 					<input type="hidden" name="photo_actuelle" value="<?= $vehicule_actuel['photo']; ?>">
 				<?php endif; ?>
 			</div>
 			<div class="form-group col-6">
 				<label>Prix</label>
 				<div class="input-group">
 					<input type="number" name="prix" placeholder="Prix journalier" class="form-control" value="<?= $vehicule_actuel['prix_journalier'] ?? '' ?>">
 				</div>
 			</div>
 		</div>
 		
 		<div class="form-group col-6">
    	<div><label><br></label></div>
    	<input type="submit" name="inscription" value="Enregistrer" class="btn btn-primary">
    	<input type="reset" class="btn btn-secondary">
    </div>

 	</form>
</div>