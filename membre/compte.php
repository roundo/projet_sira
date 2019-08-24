<?php
require('../inc/modele.php');
if( !isConnected() )
	header('location:'.RACINE_SITE);

$numLoc = 1;
$query = execRequete("SELECT * FROM commande c, vehicule v, agences a 
					  WHERE c.id_vehicule = v.id_vehicule 
					  AND c.id_agence = a.id_agence 
					  AND c.id_membre = :id_membre", 
					  array("id_membre" => $_SESSION['membre']['id_membre']) );

$historique_loca = $query->fetchAll();
require('../inc/header.php');
?>

<div class="container">
	<h2 class="text-center">
		Espace membre de <?= $_SESSION['membre']['prenom']; ?>
	</h2>
	<?php if( $historique_loca ): ?>
		<h3 class="titre">Ici, historique de vos locations !!</h3>
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Location</th>
					<th>Véhicule</th>
					<th>Agence</th>
					<th>Début</th>
					<th>Fin</th>
					<th>Prix</th>
					<th>Jours</th>
					<th>Statut</th>
					<th>Actions</th>
				</tr>
			</thead>
			<?php foreach( $historique_loca as $cle => $valeur ): ?><?php $nbj = nbjour( $valeur['date_heure_depart'], $valeur['date_heure_fin'] ) ?>
				<tr>
					<td> <?= $numLoc++; ?> </td>
					<td> <?= $valeur['marque']; ?> </td>
					<td> <?= $valeur['titre']; ?> </td>
					<td> <?= $valeur['date_heure_depart']; ?> </td>
					<td> <?= $valeur['date_heure_fin']; ?> </td>
					<td> <?= $valeur['prix_total']; ?> </td>
					<td> <?= $nbj; ?> </td>
					<td> <?= encours( $valeur['date_heure_fin'] ); ?> </td>
					<td> <a href="">louer à nouveau</a>  </td>
				</tr>
			<?php endforeach; ?>

		</table>
	<?php else: ?>
		<h3 class="titre text-center">Vous n'avez pas encore fait une location chez nous !!</h3>
	<?php endif; ?>
	
</div>


<?php
require('../inc/footer.php');