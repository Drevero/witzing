<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
if(isset($_SESSION['pseudo_inscr']) && isset($_SESSION['passe_inscr']) && isset($_SESSION['mail_inscr']))
{
	if(isset($_POST['no_robot']))
	{
		if(isset($_FILES['fichier_avat']))
		{
			if($_FILES['fichier_avat']['error']==0 && $_FILES['fichier_avat']['size']<2000000)
			{
				$inf_avat=pathinfo($_FILES['fichier_avat']['name']);
				$avat_ext=$inf_avat['extension'];
				$avat_ext_auto=array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
				if(in_array($avat_ext, $avat_ext_auto))
				{
					$nmb_al=mt_rand(0, 500);
					$nom_fichier='../data/avatars/'  . '47n' . date('Y') . '' . date('m') . '' . date('d') . '' . date('H') . '' . date('i') . '' . date('s') . '' . $nmb_al . '89.' . $inf_avat['extension'];
					move_uploaded_file($_FILES['fichier_avat']['tmp_name'], $nom_fichier);
					redimmension_image($nom_fichier, '200', '200', $inf_avat['extension']);
				}
				else
				{
					header('Location: dernier_pas.php');
				}
			}
		}
		if($nom_fichier=='')
		{
			$nom_fichier='../data/style/portrait_defaut.png';
		}
		$req_insert_mm=$bdd->prepare('INSERT INTO membres (pseudo, passe, mail, avatar, date_inscription, badges) VALUES(:pseudo, :passe, :mail, :avatar, NOW(), \'*3*\')');
		$req_insert_mm->execute(array(
			'pseudo' => $_SESSION['pseudo_inscr'],
			'passe' => $_SESSION['passe_inscr'],
			'mail' => $_SESSION['mail_inscr'],
			'avatar' => $nom_fichier,
			));
		$recup_id=$bdd->prepare('SELECT id_membre FROM membres WHERE pseudo = :membre');
		$recup_id->execute(array(
			'membre' => $_SESSION['pseudo_inscr'],
			));
		$recup=$recup_id->fetch();
		$_SESSION=array();
		$_SESSION['id_membre']=$recup['id_membre'];
		$req_insert_notif=$bdd->prepare('INSERT INTO notifications (membre_notif, contenu, lien, avatar, lu) VALUES(:membre_notif, :contenu, :lien, :avatar, 0)');
		$req_insert_notif->execute(array(
			'membre_notif' => $recup['id_membre'],
			'lien' => 'index.php',
			'contenu' => 'Vous avez reçus votre premier badge !',
			'avatar' => '../data/style/logo.png',
			));
		header('Location: tuto.php');
	}
	if(isset($_GET['annuler']))
	{
		session_destroy();
		header('Location: ../index.php');
	}
}
else
{
	header('Location: ../index.php');
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing</title>
<link rel="stylesheet" href="../data/style/style.css"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
if(!(isset($_GET['reussie'])))
{
?>
<p id="parametre_compte_texte">Bienvenue à vous <span id="hashtag_witz">@<?php echo $_SESSION['pseudo_inscr']; ?></span> !</p>
<div id="conteneur_inscr_dernier">
	<form name="form_avatar" id="form_avatar" method="post" action="" enctype="multipart/form-data">
		<input type="file" id="fichier_avat" name="fichier_avat" onchange="visual_avatar();" accept="image/*"/>
		<input type="hidden" id="avatar_change" name="avatar_change" value="0"/>
		<input type="hidden" name="no_robot" value="true"/>
		<p id="texte_intro">Pour finaliser votre inscription (donc voir si vous n'êtes pas un robot), je vous invite à choisir un avatar que vous pourrez changer à tout moment (en confirmant la création du compte vous acceptez automatiquement <a href="a_propos.php#conditions_generale">les conditions générales d'utilisation</a>).</p>
		<img src="" onclick="changer_avatar();" alt="" id="avatar_apercu" class="avatar_inscr"/>
		<input type="submit" value="Créer le compte" id="creer_compte_confirm"/>
		<a href="dernier_pas.php?annuler" title="Annuler la création de votre compte"><input type="button" value="Annuler" id="annuler_compte_confirm"/></a>
	</form>
</div>
<script type="text/javascript" src="../data/witzing_nocon.js"></script>
<?php
}
?>
</body>
</html>
