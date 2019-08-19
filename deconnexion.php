<?php

require('inc/modele.php');

if( isset($_GET['action']) ){
	session_destroy();	
	header('location :'.RACINE_SITE);
	exit();
}




