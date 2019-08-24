<?php

	require_once('modele.php');
 
	$vehicules = execRequete("SELECT v.*, a.titre as titreagence
                            FROM vehicule v
                            INNER JOIN agences a
                            ON v.id_agence = a.id_agence
                            ORDER BY v.titre DESC");

              //INNER JOIN commande c  ON c.id_vehicule = c.id_vehicule  GROUP BY v.id_vehicule


  if ( $vehicules->rowCount() > 0 ) : ?>
    
    <?php while( $vehicule = $vehicules->fetch(PDO::FETCH_ASSOC) ): ?>	
    	<?php   extract($vehicule); ?>			
      <div class="accueil_vehicule card text-center container">
        
    		<?php if(!empty($photo)): ?>
          <div>
            <img src="<?= RACINE_SITE . 'utilities/img/' . $photo ?>" alt="<?= $titre ?>" class="img-fluid">
          </div>
        <?php endif; ?>              
        <div><strong><?= $titre ?></strong></div>
        
          <?= $description ?>
        
          <div><?= $prix_journalier ?> € / jour- <?= $titreagence ?></div>
          <br>
          <a href="<?= RACINE_SITE .'template/reservation.php?reservation='.$id_vehicule ?>" class="btn btn-success <?= enLocation($id_vehicule) ? 'disabled' : '' ?>">Réserver</a>
			  <hr>
      </div>
    <?php endwhile; ?>
  <?php else : ?>
      <p colspan="6">Pas encore de véhicules enregistrés!!</p>
  <?php endif; ?>
