<?php 
require('../inc/modele.php');
if( !isConnected() ){
	$_SESSION['reserv'] = '<h2 class="text-center pt-5">Connectez vous!!</h2>';
	header('location:'.RACINE_SITE);
	exit();
}

$query = execRequete("SELECT v.*, a.id_agence from vehicule v, agences a 
					  WHERE id_vehicule = :idv 
					  AND v.id_agence = a.id_agence", 
					 array("idv" => $_GET['reservation']));

$reservation = $query->fetch();

/* Cas réservation */
if( !empty($_POST['date_debut']) && $_POST['date_fin'] > $_POST['date_debut'] ){
	extract($_POST);
	var_dump($_POST);
	$prix_total = nbJour($date_debut, $date_fin) * $pttc;

	$query = execRequete("INSERT INTO commande(id_membre, id_vehicule, id_agence, date_heure_depart, date_heure_fin, prix_total)
						 VALUES(:id_membre, :id_vehicule, :id_agence, :dd, :df, :pttc )",
						 array(
						 		"id_membre" => $id_membre,
						 		'id_vehicule' => $id_vehicule,
						 		'id_agence' => $id_agence,
						 		'dd' => $date_debut,
						 		'df' => $date_fin,
						 		'pttc' => $prix_total
						 ));
	header('location:'.RACINE_SITE.'membre/compte.php');
}


require('../inc/header.php');

if( isConnected() ):
?>
	<div class="container">
	<div class="row">
		<div class="col-2 mt-5"><?= $reservation['marque'].' - '.$reservation['modele']; ?>
		<br>
		Prix journalier <?= $reservation['prix_journalier']; ?></div>
		<div class="col-3"><img src="<?= RACINE_SITE.'utilities/img/'. $reservation['photo']; ?>"></div>
	</div>
	<form class="formulaire" method="post" action="">

		<input type="hidden" name="id_membre" value="<?= $_SESSION['membre']['id_membre']; ?>">
		<input type="hidden" name="id_vehicule" value="<?= $reservation['id_vehicule']; ?>">
		<input type="hidden" name="id_agence" value="<?= $reservation['id_agence']; ?>">
		<input type="hidden" name="pttc" value="<?= $reservation['prix_journalier']; ?>">

		<div class="row">
			<div class="form-group col-3">
				<label>Date de début</label>
				<div class="input-group">
					<input type="date" name="date_debut" class="form-control">
				</div>
			</div>
			<div class="form-group col-3">
				<label>Date de fin</label>
				<div class="input-group">
					<input type="date" name="date_fin" class="form-control">
				</div>
			</div>
			<!--  -->
		</div>
		<input type="submit" name="inscription" value="Réserver" class="btn btn-primary">
    	<input type="reset" class="btn btn-secondary">
	</form>
</div>


<?php endif;
require('../inc/footer.php');