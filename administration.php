<?php

/*********************************************************
*****************  PAGE D'ACCUEIL  ***********************
**********************************************************/

require_once('inc/modele.php');

require_once('inc/header.php');


if( isset($_POST['requete']) ){
	$r = execRequete("SELECT column_name FROM information_schema.columns WHERE table_name = 'membre' AND table_schema='projet_sira'");

	$r = $r->fetchAll();
	var_dump($r);

}
	



?>

<form accept="" method="post">
	<textarea name="requete">


		
	</textarea>
<input type="submit" name="">
</form>

<?php
require_once('inc/footer.php');