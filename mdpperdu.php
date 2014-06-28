<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
session_start();
include('data/bdd.php');
if(isset($_SESSION['id_membre']))
{
	header('Location: p/index.php?id=' . $_SESSION['id_membre']);
}
if(isset($_POST['mail_mdpperdu']))
{
	$req_mail=$bdd->prepare('SELECT * FROM membres WHERE mail = :mail');
	$req_mail->execute(array(
		'mail' => $_POST['mail_mdpperdu'],
		));
	$mail=$req_mail->fetch();
	if($mail)
	{
		mail($mail['mail'], 'Mot de passe perdu !', 'Salut ' . htmlspecialchars($mail['pseudo']) . ' voilà vos identifiants de connexion pour Witzing :<br />Adresse Email : ' . $mail['mail'] . '<br />Mot de passe : ' . htmlspecialchars($mail['passe']) . '<br />Sur ce, Bon séjour sur Witzing et très bonne journée, Cordialement, Drevero.');
		header('Location: mdpperdu.php?email_envoye');
	}
	else
	{
		header('Location: mdpperdu.php?email_incorrect');
	}
	$req_mail->closeCursor();
}
include('licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta property="og:title" content="Bienvenue sur Witzing" />
<meta property="og:type" content="website" />
<meta property="og:image" content="data/style/logo.png" />
<meta name="description" content="Bienvenue sur Witzing, un réseau social 100% libre et Français"/>
<meta name="keywords" content="Witzing"/>
<title>Witzing - Mot de passe perdu ?</title>
<link rel="stylesheet" href="data/style/style.php"/>
<link rel="icon" href="data/style/logo.png" type="image/png" />
</head>
<body>
<?php
if(!isset($_GET['email_envoye']) && !isset($_GET['email_incorrect']))
{
?>
	<p id="titre_a_propos">Mot de passe perdu ?</p>
	<p class="texte_contenu_a_propos centre">Ecrivez ci-dessous votre adresse Email, une copie de votre mot de passe vous sera alors envoyé, bonne journée !</p>
	<form name="mdpperdu" method="post">
		<input type="mail" placeholder="Adresse Email" name="mail_mdpperdu" maxlength="350" class="saisie centre_block"/>
		<input type="submit" value="" class="invisible"/>
	</form>
<?php
}
else
{
	if(isset($_GET['email_envoye']) && !isset($_GET['email_incorrect']))
	{
?>
	<p id="titre_a_propos">Email envoyé !</p>
	<p class="texte_contenu_a_propos centre">Un Email contenant une copie de votre mot de passe vient de vous être envoyé !</p>
	<a href="index.php" title="Retour à l'accueil" id="retour_accueil">Retour à l'accueil</a>
<?php
	}
	else
	{
?>
	<p id="titre_a_propos">Adresse Email incorrecte ...</p>
	<p class="texte_contenu_a_propos centre">Assurez-vous d'avoir un compte sur Witzing ou de ne pas avoir mal écrit votre adresse Email</p>
	<form name="mdpperdu" method="post">
		<input type="mail" placeholder="Adresse Email" name="mail_mdpperdu" maxlength="350" class="saisie centre_block"/>
		<input type="submit" value="" class="invisible"/>
	</form>
<?php
	}
}
?>
<script type="text/javascript" src="data/witzing_nocon.js"></script>
</body>
</html>
