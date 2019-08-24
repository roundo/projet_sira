<?php
/*debut de session sur ce fichier que j'inclus partout. Cela me permet de ne pas faire session_start partout*/
session_start();

$pdo = new PDO
	('mysql:host=localhost;dbname=projet_sira',
	 'root', '',
	 [
	 	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	  	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	  ]
	);

$pdo->exec("SET NAMES UTF8");


define("RACINE_SITE", "/projet_sira/");

require_once("fonctions.php");

