<?php
require('../inc/modele.php');

if( !isAdmin() ){
	header("location:".RACINE_SITE);
	exit();
}

$membres = execRequete("SELECT * FROM membre");
//$membres = $membres->fetchAll();

/*Cas de suppression*/
if( isset($_GET['supp']) && $_GET['supp'] == 'suppression' ){
	execRequete("DELETE FROM membre WHERE id_membre = ?", array($_GET['id']));
	header("location:".RACINE_SITE."admin/gestion_membre.php");
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
	header("location:".RACINE_SITE."admin/gestion_membre.php");
}

require('../inc/header.php');
?>

	<div class="container">
		<h3 class="titre">Gestion des Membres</h3>
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
			<tr scope="col">
				<th>Pseudo</th>
				<th>Prénom</th>
				<th>Nom</th>
				<th>Email</th>
				<th>Civilité</th>
				<th>Statut</th>
				<th>Date enrégistrement</th>
				<th>Actions	</th>
			</tr>
		</thead>
	<?php while($membre = $membres->fetch()): ?>
		<?php extract($membre); ?>
		<tr>
			<td><?= $pseudo; ?></td>
			<td><?= $prenom; ?></td>
			<td><?= $nom; ?></td>
			<td><?= $email; ?></td>
			<td><?= $civilite; ?></td>
			<td><?= $statut; ?></td>
			<td><?= $date_enregistrement; ?></td>
			<td>
				<a href="?action=modification&id=<?= $id_membre ?>"><i class="fas fa-pen"></i>
				</a> 
				- 
				<a href="?action=suppression&id=<?= $id_membre ?>"><i class="fas fa-trash-alt"></i>
				</a> 
			</td>
		</tr>
	<?php endwhile; ?>
	</table>
	<hr>
	<!-- formulaire  Ajout/Modication -->
		<h4 class="titre">Ajout/Modif d'un Membre</h4>
		<form action="" method="post" class="formulaire">
			<input type="hidden" name="id_membre" value="<?= $membre_actuel['id_membre'] ?? 0 ?>">
			<div class="row">
				<div class="form-group col-6">
					<label for="pseudo">Pseudo</label>
					<div class="input-group">
						<input type="text" name="pseudo" class="form-control" placeholder="Votre pseudo" value="<?= $membre_actuel['pseudo'] ?? '' ?>">
					</div>
				</div>
				<div class="form-group col-6">
					<label for="meil">E-mail</label>
					<div class="input-group">
						<input type="email" name="mail" class="form-control" placeholder="Votre Mail" value="<?= $membre_actuel['email'] ?? '' ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-6">
					<label for="mdp">Mot de passe</label>
					<div class="input-group">
						<input type="password" name="mdp" class="form-control" placeholder="Votre password" value="<?= $membre_actuel['mdp'] ?? '' ?>">
					</div>
				</div>
				<div class="form-group col-2">
					<label for="civilite">Civilité</label>
					<select class="form-control" name="civilite">
			        	<option value="m" <?= isset($membre_actuel['civilite']) && $membre_actuel['civilite']=='m' ? 'selected' : '' ?>>Homme</option>   
			      		<option value="f" <?= isset($membre_actuel['civilite']) && $membre_actuel['civilite']=='f' ? 'selected' : '' ?>>Femme</option>        
			      </select>                
			    </div>
			</div>
			<div class="row">
				<div class="form-group col-6">
					<label for="nom">Nom</label>
					<div class="input-group">
						<input type="text" name="nom" class="form-control" placeholder="Votre nom" value="<?= $membre_actuel['nom'] ?? '' ?>">
					</div>
				</div>
			    <div class="form-group col-2">
			    	<label for="statut">Statut</label>
			    	<select class="form-control" name="statut">
			        <option value="1" <?= isset($membre_actuel['statut']) && $membre_actuel['statut']=='1' ? 'selected' : '' ?>>Admin</option>   
			        <option value="0" <?= isset($membre_actuel['statut']) && $membre_actuel['statut']=='0' ? 'selected' : '' ?>>Client</option>        
			      </select>                
			    </div>
			</div>
			<div class="row">
				<div class="form-group col-6">
					<label for="prenom">Prénom</label>
					<div class="input-group">
						<input type="text" name="prenom" class="form-control" placeholder="Votre prénom" value="<?= $membre_actuel['prenom'] ?? '' ?>">
					</div>
				</div>
			    <div class="form-group col-6">
			    	<div><label><br></label></div>
			    	<input type="submit" name="inscription" value="Enregistrer" class="btn btn-primary">
			    	<input type="reset" class="btn btn-secondary">
			    </div>
			</div>
		</form>
	</div>

	<?php
	require('../inc/footer.php');