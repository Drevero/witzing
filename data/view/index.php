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
<body class="body_accueil" style="background-image: url('<?php echo 'data/fond_accueil/' . $array_fond_index[$nmb_al_fd] . '.jpg'; ?>');">
<div id="bandeau" class="bandeau_accueil">
	<div id="cont_con">
		<form name="connexion" method="post">
			<input type="mail" placeholder="Adresse Email" name="mail" maxlength="350" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
			<input type="password" placeholder="Mot de Passe" name="passe" maxlength="256" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
			<?php if(isset($_GET['i']))
			{
				echo '<a href="mdpperdu.php" id="mdpperdu" title="Mot de passe perdu ?">Mot de passe perdu ?</a>';
			}
			?>
			<input type="submit" value="" id="con"/>
		</form>
	</div>
</div>
<?php
if(isset($_GET['erreur']))
{
	echo '<p id="info_utile_inscr">Désolé mais un membre utilise déjà ce pseudonyme</p>';
}
?>
<div id="conteneur_presentation">
	<div id="cont_con_mobile">
		<form name="connexion_mobile" method="post">
			<input type="mail" placeholder="Adresse Email" name="mail" maxlength="350" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
			<input type="password" placeholder="Mot de Passe" name="passe" maxlength="256" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
			<?php if(isset($_GET['i']))
			{
				echo '<a href="mdpperdu.php" id="mdpperdu" title="Mot de passe perdu ?">Mot de passe perdu ?</a>';
			}
			?>
			<input type="submit" value="" id="con_mobile"/>
		</form>
	</div>
	<div id="conteneur_avantages">
		<p id="titre_witzing_pres">Bienvenue sur <span id="hashtag_witz">#Witzing0.6</span></p>
		<p id="pres_witzing">-Un réseau social libre, performant et gratuit !<br /><br />-Un réseau social qui dit non aux C.G.U. privatives !<br /><br />-Un réseau social différent !<br /><br />Si vous n'êtes pas inscrit, n'hésitez pas c'est facile (et c'est juste à droite)<br /><a href="p/a_propos.php" title="En savoir +">Découvrir les fonctionnalitées !</a></p>
	</div>
	<img src="data/style/plis.png" alt="plis" id="plis_index"/>
	<div id="conteneur">
		<p>Devenir un Witzeur !</p>
		<form name="inscription" id="inscr_form" onsubmit="verif_inscr();return false;" method="post">
			<input type="text" onfocus="afficher_info_bulle('info_inscr_inter', true);" onblur="afficher_info_bulle('info_inscr_inter', false);" placeholder="Pseudonyme" name="pseudo_inscr" id="pseudo_inscr" class="saisie" maxlength="20"/>
			<p id="info_inscr_inter"><img src="data/style/fleche_droite.png" alt="fleche_droite" id="fleche_inter"/>Interdiction d'utiliser les caractères suivants : &lt;, espace ...</p>
			<input type="text" placeholder="Adresse Email" name="mail_inscr" id="mail_inscr" class="saisie" maxlength="350"/>
			<input type="password" placeholder="Mot de passe" name="passe_inscr" id="passe_inscr" class="saisie" maxlength="256"/>
			<input type="submit" value="Inscription" id="inscription"/>
		</form>
	</div>
</div>
<script type="text/javascript" src="data/witzing_nocon.js"></script>
</body>
</html>
