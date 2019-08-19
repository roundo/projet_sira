<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Projet Sira</title>
	<link rel="stylesheet" href="<?= RACINE_SITE. 'utilities/css/bootstrap/css/bootstrap.min.css'?>">
  <link rel="stylesheet" href="<?= RACINE_SITE. 'utilities/css/bootstrap/js/bootstrap.min.js'?>">
	<!-- Scripts nécessaires pour Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>
  <!-- css perso -->
  <link rel="stylesheet" href="<?= RACINE_SITE .'utilities/css/font/css/all.css'?>">
  <link rel="stylesheet" href="<?= RACINE_SITE. 'utilities/css/style.css'?>">
  <link rel="stylesheet" href="<?= RACINE_SITE .'utilities/css/normalize.css' ?>">
</head>
<body>
	<header class="text-center">
    <h1 class="text-light text-center pt-5">
    	Bienvenue à Bord
    </h1>
    <h2 class="text-light text-center">Location de véhicule 24h/24 7j/7</h2>

    <?php if( isConnected() ): ?>
      <div class="text-light text-right">
        <strong>Bonjour <?= $_SESSION['membre']['prenom']; ?></strong>
      </div>
      <a href="<?= RACINE_SITE ?>" class="btn btn-warning">Accueil</a>
      <a href="<?= RACINE_SITE.'membre/compte.php'?>" class="btn btn-warning">Mon compte</a>
      <?php if( isAdmin() ): ?>
        <a href="<?= RACINE_SITE.'admin/gestion_agence.php'?>" class="btn btn-success">Agence</a>
        <a href="<?= RACINE_SITE.'admin/gestion_vehicule.php'?>" class="btn btn-success">Véhicule</a>
        <a href="<?= RACINE_SITE.'admin/gestion_membre.php'?>" class="btn btn-success">Membre</a>
        <a href="<?= RACINE_SITE.'membre/compte.php'?>" class="btn btn-success">Commandee</a>
      <?php endif; ?>
      <a href="<?= RACINE_SITE .'connexion.php?action=deconnexion' ?>" class="btn btn-danger">
        Déconnexion
      </a>
      <?php else: ?>

        <button class="btn btn-success" data-toggle="modal" data-target="#inscription">
        	Inscription
        </button>
        <button class="btn btn-success" data-toggle="modal" data-target="#connexion">
        	Connexion
        </button>
      <?php endif; ?>

    <!-- Modal inscription -->
    <div class="modal fade" id="inscription" tabindex="-1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">S'inscrire</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?= RACINE_SITE .'inscription.php'?>">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name="pseudo" placeholder="votre pseudo" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" name="mdp" placeholder="votre password" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name="nom" placeholder="votre nom" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name="prenom" placeholder="votre prénom" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name="mail" placeholder="votre courriel" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <select class="form-control" name="civilite">
                  <option value="m">Homme</option>   
                  <option value="f">Femme</option>          
                </select>                
              </div>
              <input type="submit" name="inscription" value="S'inscrire" class="btn btn-primary">
              <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </form>
          </div>
          </div>
      </div>
    </div>
    <!-- Fin modal inscription -->

    <!-- Modal connexion -->
    <div class="modal fade" id="connexion" tabindex="-1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Se connecter</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?= RACINE_SITE .'connexion.php'?>">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name="pseudo" placeholder="votre pseudo" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" name="mdp" placeholder="votre password" class="form-control">
                </div>
              </div>
              <input type="submit" name="inscription" value="Se connecter" class="btn btn-primary">
              <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal connexion -->
    
  </header>
	<main>
    <?php if(isset($_SESSION['erreur'])){ 
            echo "<h3 class='erreurLog'>".$_SESSION['erreur']."</h3>"; 
            unset($_SESSION['erreur']); 
          }if( isset($_SESSION['inscription']) ){
            echo $_SESSION['inscription'];
            unset( $_SESSION['inscription'] );
          }if( isset($_SESSION['err']) ){
            echo "<h3 class='erreurLog'>".$_SESSION['err']."</h3>";
            unset($_SESSION['err']);
          }

    ?>