<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('data/bdd.php');
if(isset($_POST['mail']) && isset($_POST['passe']))
{
	$req_con=$bdd->prepare('SELECT * FROM membres WHERE mail = :mail and passe = :passe');
	$req_con->execute(array(
		'mail' => $_POST['mail'],
		'passe' => $_POST['passe'],
		));
	$result=$req_con->fetch();
	if($result)
	{
		$_SESSION['id_membre']=$result['id_membre'];
		$req_con=$bdd->prepare('UPDATE membres SET dernier_activite = NOW(), derniere_con = NOW() WHERE mail = :mail AND passe = :passe');
		$req_con->execute(array(
			'mail' => $_POST['mail'],
			'passe' => $_POST['passe'],
			));
		header('Location: p/index.php');
	}
	else
	{
		header('Location: index.php?i');
	}
	$req_con->closeCursor();
}
if(isset($_SESSION['id_membre']))
{
	header('Location: p/index.php?id=' . $_SESSION['id_membre']);
}
if(isset($_SESSION['pseudo_inscr']))
{
	session_destroy();
	header('Location: index.php');
}
if(isset($_POST['pseudo_inscr']) && isset($_POST['mail_inscr']) && isset($_POST['passe_inscr']))
{
	if(strlen($_POST['pseudo_inscr'])>3 && strlen($_POST['passe_inscr'])>3  && !preg_match('# #isU', $_POST['pseudo_inscr']) && !preg_match('#>#isU', $_POST['pseudo_inscr']) && preg_match('#(.+)@(.+)\.(.+)#', $_POST['mail_inscr']))
	{
		$req_membre=$bdd->prepare('SELECT pseudo FROM membres WHERE pseudo = :pseudo');
		$req_membre->execute(array(
			'pseudo' => $_POST['pseudo_inscr'],
			));
		$membre=$req_membre->fetch();
		$req_mail=$bdd->prepare('SELECT mail FROM membres WHERE mail = :mail');
		$req_mail->execute(array(
			'mail' => $_POST['mail_inscr'],
			));
		$mail=$req_mail->fetch();
		if($membre || $mail)
		{
			if($membre)
			{
				header('Location: index.php?erreur');
			}
			if($mail)
			{
				header('Location: index.php?erreur2');
			}
		}
		else
		{
			$_SESSION['pseudo_inscr']=$_POST['pseudo_inscr'];
			$_SESSION['passe_inscr']=$_POST['passe_inscr'];
			$_SESSION['mail_inscr']=$_POST['mail_inscr'];
			header('Location: p/dernier_pas.php');
		}
		$req_membre->closeCursor();
		$req_mail->closeCursor();
	}
}
$array_fond_index=array('field', 'winter_track', 'spring_sunray', 'aghi', 'leaf_labyrinth', 'quadros', 'colorado_farm', 'evening', 'field_of_peace', 'horos');
$nmb_al_fd=mt_rand(0, count($array_fond_index)-1);
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
<link rel="stylesheet" href="data/style/style.css"/>
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
	echo '<p id="info_utile_inscr">Désolé mais un membre utilise déjà le même pseudonyme</p>';
}
if(isset($_GET['erreur2']))
{
	echo '<p id="info_utile_inscr">Désolé mais un membre utilise déjà cette adresse email</p>';
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
