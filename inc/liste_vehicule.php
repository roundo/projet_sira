<?php

	require_once('modele.php');
  $date = date('Y-m-d');
	$vehicules = execRequete("SELECT v.*,a.titre as titreagence, date_heure_fin 
                            FROM vehicule v
                            INNER JOIN agences a
                            ON v.id_agence = a.id_agence
                            LEFT JOIN commande c 
                            ON v.id_vehicule = c.id_vehicule 
                            ORDER BY v.titre");

    if ( $vehicules->rowCount() > 0 ) : ?>

      <?php while( $vehicule = $vehicules->fetch(PDO::FETCH_ASSOC) ): ?>	
      	<?php   extract($vehicule); ?>			
        <div class="accueil_vehicule">
          
      		<?php if(!empty($photo)): ?>
            <div>
              <img src="<?= RACINE_SITE . 'utilities/img/' . $photo ?>" alt="<?= $titre ?>" class="img-fluid">
            </div>
          <?php endif; ?>              
          <div><strong><?= $titre ?></strong></div>
          
            <?= $description ?>
          
            <div><?= $prix_journalier ?> € / jour- <?= $titreagence ?></div>
            <br>
            <a href="<?= RACINE_SITE .'template/reservation.php?reservation='.$id_vehicule ?>" class="btn btn-success <?= $date_heure_fin > $date ? 'disabled' : '' ?>">Réserver</a>
				  <hr>
        </div>
      <?php endwhile; ?>
    <?php else : ?>
        <p colspan="6">Pas encore de véhicules enregistrés!!</p>
    <?php endif; ?>
