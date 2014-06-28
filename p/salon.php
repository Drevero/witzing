<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
include('../licence_include.php');
$req_nmb_inscr=$bdd->query('SELECT COUNT(*) AS nmb_inscr FROM membres');
$nmb_inscr=$req_nmb_inscr->fetch();
$req_nmb_co=$bdd->query('SELECT COUNT(*) AS nmb_co FROM membres WHERE derniere_activite >= \'' . date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H') . ':' . (date('i')-1) . ':00\'');
$nmb_co=$req_nmb_co->fetch();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Le Salon</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<div id="conteneur_membre">
<?php
include('../data/bandeau.php');
?>
<?php
if(!isset($_GET['verif']))
{
?>
	<div id="conteneur_intro_salon">
		<p id="parametre_compte_texte">Bienvenue à tous dans le <span id="hashtag_witz">#Salon</span></p>
		<p id="sous_titre_salon">Ici vous pouvez parler librement avec toute la communauté Witzing pour faire de nouvelles rencontres ou débattre autour d'un sujet, bon amusement ! <br/><br />Witzing en chiffres c'est <span id="nmb_inscr"><?php echo $nmb_inscr['nmb_inscr']; ?></span> inscrits et <span id="nmb_co"><?php echo $nmb_co['nmb_co']; ?></span> connectés !</p>
		<a href="salon.php?verif" id="bouton_ouvrir_salon">Ouvrir le salon</a>
	</div>
<?php
}
else
{
?>
<div id="conteneur_message_salon">
</div>
<form name="salon" method="post" id="salon_form" onsubmit="envois_message_salon(document.getElementById('cont_message_salon').value);return false;">
	<input type="text" placeholder="Tapez ici votre message ..." maxlength="600" id="cont_message_salon"/>
	<img src="../data/emoticons/smile2.png" onclick="boite_smiley('cont_message_salon');" id="bt_ouvrir_smilesalon"/>
</form>
<?php
}
?>
<script type="text/javascript" src="../data/witzing.php"></script>
<?php
if(isset($_GET['verif']))
{
?>
</div>
<script>
message_salon_commun();
</script>
<?php
}
else
{
?>
<script>
recup_nmb_inscr();
</script>
<?php
}
?>
</body>
</html>
