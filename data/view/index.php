<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
include('licence_include.php');
?>
<!doctype html>
<html class="html_accueil">
<head>
<meta charset="utf-8"/>
<meta property="og:title" content="Bienvenue sur Witzing" />
<meta property="og:type" content="website" />
<meta property="og:image" content="data/style/logo.png" />
<meta name="description" content="Bienvenue sur Witzing, un réseau social 100% libre et Français"/>
<meta name="keywords" content="Witzing"/>
<title>Witzing - Connexion</title>
<meta name="viewport" content="width=device-width,user-scalable=no">
<link rel="stylesheet" href="data/style/style.php"/>
<link rel="icon" href="data/style/logo.png" type="image/png" />
</head>
<body class="body_accueil">
<div id="cont_accueil">
<img src="data/style/logo.png" id="logo_home"/>
<form name="connexion" method="post">
	<input type="mail" placeholder="Adresse Email" name="mail" maxlength="350" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
	<input type="password" placeholder="Mot de Passe" name="passe" maxlength="256" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
	<div id="cont_bt_inscr_co">
		<input type="button" value="Inscription" id="bt_inscr"/>
		<input type="submit" value="Connexion" id="bt_co"/>
		<?php if(isset($_GET['i']))
		{
			echo '<a href="mdpperdu.php" id="mdpperdu" title="Mot de passe perdu ?">Mot de passe perdu ?</a>';
		}
	?>
	</div>
	<input type="submit" value="" id="con"/>
</form>
</div>
<?php
if(isset($_GET['erreur']))
{
	echo '<p id="info_utile_inscr">Désolé mais un membre utilise déjà ce pseudonyme</p>';
}
?>
<script type="text/javascript" src="data/witzing_nocon.js"></script>
</body>
</html>
