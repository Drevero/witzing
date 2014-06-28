<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Tutoriel</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
	<p id="parametre_compte_texte">Bienvenue sur Witzing !</p>
	<div id="conteneur_inscr_dernier" class="tuto_inscr">
		<p id="texte_intro">Libre à vous maintenant de profiter pleinement d'un tout nouveau réseau social libre, si vous avez besoin d'aide n'hésitez surtout pas à m'envoyer un message <a href="index.php?id=1">@Drevero</a> !</p>
		<a href="../index.php" title="Retour à la page d'accueil"><input type="button" value="Allez sur mon fil d'actu" id="annuler_compte_confirm"/></a>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
</body>
</html>
