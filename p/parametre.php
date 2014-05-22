<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
if(!isset($_SESSION['id_membre']))
{
	header('Location: ../index.php');
}
include('../data/bdd.php');
include('../data/standard.php');
if(isset($_POST['pseudo_mod']) && isset($_POST['email_mod']) && isset($_POST['avatar_change']) && isset($_POST['mdp1_mod']) && isset($_POST['mdp2_mod']) && isset($_FILES['fichier_avat']) && isset($_POST['theme_filactu']) && $_POST['theme_filactu']<=$theme_url && isset($_POST['fond_change']) && isset($_FILES['fichier_fond']))
{
	if(strlen($_POST['pseudo_mod'])>3 && !preg_match('# #isU', $_POST['pseudo_mod']) && !preg_match('#>#isU', $_POST['pseudo_mod']))
	{
		if(strlen($_POST['email_mod'])>3)
		{
			if(strlen($_POST['mdp1_mod'])>3)
			{
				if(preg_match('#(.+)@(.+)\.(.+)#', $_POST['email_mod']))
				{
					$req_membre=$bdd->prepare('SELECT pseudo FROM membres WHERE pseudo = :pseudo AND id_membre != :id_membre');
					$req_membre->execute(array(
						'pseudo' => $_POST['pseudo_mod'],
						'id_membre' => $_SESSION['id_membre'],
						));
					$membre=$req_membre->fetch();
					$req_mail=$bdd->prepare('SELECT mail FROM membres WHERE mail = :mail AND id_membre != :id_membre');
					$req_mail->execute(array(
						'mail' => $_POST['email_mod'],
						'id_membre' => $_SESSION['id_membre'],
						));
					$mail=$req_mail->fetch();
					if($membre || $mail)
					{
						if($membre)
						{
							header('Location: parametre.php?erreur');
						}
						if($mail)
						{
							header('Location: parametre.php?erreur2');
						}
					}
					else
					{
						$maj_compte=$bdd->prepare('UPDATE membres SET pseudo = :pseudo, passe = :passe, mail = :email, theme_fil = :theme_fil WHERE id_membre = :id_membre');
						$maj_compte->execute(array(
							'pseudo' => $_POST['pseudo_mod'],
							'passe' => $_POST['mdp1_mod'],
							'email' => $_POST['email_mod'],
							'theme_fil' => $_POST['theme_filactu'],
							'id_membre' => $_SESSION['id_membre'],
							));
						if($_POST['avatar_change']=='1')
						{
							if($_FILES['fichier_avat']['error']==0)
							{
								$inf_avat=pathinfo($_FILES['fichier_avat']['name']);
								$avat_ext=$inf_avat['extension'];
								$avat_ext_auto=array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
								if(in_array($avat_ext, $avat_ext_auto) && $_FILES['fichier_avat']['size']<2000000)
								{
									if($recherche['avatar']!='../data/style/portrait_defaut.png')
									{
										unlink($recherche['avatar']);
									}
									$nmb_al=mt_rand(0, 500);
									move_uploaded_file($_FILES['fichier_avat']['tmp_name'], '../data/avatars/' . 'avat' . $_SESSION['id_membre'] . '' . $nmb_al . '.' . $inf_avat['extension']);
									redimmension_image('../data/avatars/' . 'avat' . $_SESSION['id_membre'] . '' . $nmb_al . '.' . $inf_avat['extension'], '200', '200', '../data/avatars/' . 'avat' . $_SESSION['id_membre'] . '' . $nmb_al . '.' . $inf_avat['extension'], $inf_avat['extension']);
									$maj_compte_avatar=$bdd->prepare('UPDATE membres SET avatar = :avatar_url WHERE id_membre = :id_membre');
									$maj_compte_avatar->execute(array(
										'avatar_url' => '../data/avatars/' . 'avat' . $_SESSION['id_membre'] . '' . $nmb_al . '.' . $inf_avat['extension'],
										'id_membre' => $_SESSION['id_membre'],
										));
									for($i=0;$i<count($liste_suiveur);$i++)
									{
										if($liste_suiveur[$i]!='')
										{
											creer_notif($liste_suiveur[$i], 'index.php?id=' . $_SESSION['id_membre'], $recherche['pseudo'] . ' à changé de photo de profil', '../data/avatars/' . 'avat' . $_SESSION['id_membre'] . '' . $nmb_al . '.' . $inf_avat['extension']);
										}
									}
								}
								else
								{
									header('Location: parametre.php');
								}
							}
						}
						if($_POST['fond_change']=='1')
						{
							if($_FILES['fichier_fond']['error']==0)
							{
								$inf_fond=pathinfo($_FILES['fichier_fond']['name']);
								$fond_ext=$inf_fond['extension'];
								$fond_ext_auto=array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
								if(in_array($fond_ext, $fond_ext_auto) && $_FILES['fichier_fond']['size']<1000000)
								{
									if($recherche['fond_fil']!='')
									{
										unlink($recherche['fond_fil']);
									}
									$url_fond='../data/fonds/' . 'fond' . $_SESSION['id_membre'] . '12e' . date('Y') . '' . date('m') . '' . date('d') . '' . date('H') . '' . date('i') . '' . date('s') . '.' . $inf_fond['extension'];
									move_uploaded_file($_FILES['fichier_fond']['tmp_name'], $url_fond);
									$maj_compte_fond=$bdd->prepare('UPDATE membres SET fond_fil = :fond_fil WHERE id_membre = :id_membre');
									$maj_compte_fond->execute(array(
										'fond_fil' => $url_fond,
										'id_membre' => $_SESSION['id_membre'],
										));
								}
							}
						}
						header('Location: parametre.php?reussi');
					}
					$req_membre->closeCursor();
					$req_mail->closeCursor();
				}
			}
		}
	}
}
if(isset($_GET['supr_fond']))
{
	if($recherche['fond_fil']!='')
	{
		unlink($recherche['fond_fil']);
		$maj_compte_fond=$bdd->prepare('UPDATE membres SET fond_fil = :fond_fil WHERE id_membre = :id_membre');
		$maj_compte_fond->execute(array(
			'fond_fil' => '',
			'id_membre' => $_SESSION['id_membre'],
			));
		header('Location: parametre.php?reussi');
	}
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Paramètres</title>
<link rel="stylesheet" href="../data/style/style.css"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<div id="conteneur_membre">
<?php
include('../data/bandeau.php');
?>
<?php
if(isset($_GET['erreur']))
{
	echo '<p id="info_utile">Désolé mais un membre utilise déjà le même pseudonyme</p>';
}
if(isset($_GET['erreur2']))
{
	echo '<p id="info_utile">Désolé mais un membre utilise déjà cette adresse email</p>';
}
if(isset($_GET['reussi']) && !(isset($_GET['erreur'])) && !(isset($_GET['erreur2'])))
{
	echo '<p id="info_utile">Les modifications relatives à votre compte ont été appliquées</p>';
}
?>
	<div id="conteneur_parametre">
		<form name="form_mod" id="form_mod" method="post" action="" enctype="multipart/form-data">
			<label for="pseudo_mod">Pseudonyme </label><input type="text" maxlength="20" value="<?php echo htmlspecialchars($recherche['pseudo']); ?>" placeholder="Merci d'entrer un pseudonyme comportant au moins 3 caractères" name="pseudo_mod" id="pseudo_mod"/><br /><br /><br />
			<label for="email_mod">Adresse Email </label><input type="text" maxlength="350" value="<?php echo htmlspecialchars($recherche['mail']); ?>" placeholder="Merci d'entrer une adresse e-mail valide" name="email_mod" id="email_mod"/><br /><br /><br />
			<label for="mdp1_mod">Mot de passe </label><input type="password" maxlength="256" value="<?php echo htmlspecialchars($recherche['passe']); ?>" placeholder="Merci d'entrer un mot de passe comportant au moins 3 caractères" name="mdp1_mod" id="mdp1_mod"/><br /><br /><br />
			<label for="mdp2_mod">Mot de passe *</label><input type="password" maxlength="256" value="<?php echo htmlspecialchars($recherche['passe']); ?>" placeholder="Merci d'entrer le mot de passe identique" name="mdp2_mod" id="mdp2_mod"/><br /><br /><br />
			<label for="theme_filactu">Thème de votre fil d'actu </label>
			<select name="theme_filactu" id="theme_fil_actu">
				<?php echo '<option value=' . $recherche['theme_fil'] . '">' . $theme_nom[$recherche['theme_fil']] . '</option>';
				for($i=0;$i<count($theme_nom);$i++)
				{
					if($i!=$recherche['theme_fil'])
					{
						echo '<option value=' . $i . '">' . $theme_nom[$i] . '</option>';
					}
				}
				?>
			</select><br /><br />
			<label for="fond_filactu">Fond de votre fil d'actu </label>
			<input type="button" value="A" onclick="changer_fond();" class="fond_fil_bt"/>
			<?php if($recherche['fond_fil']!='') { ?><a href="parametre.php?supr_fond"><input type="button" value="I" class="fond_fil_bt poubelle_fond"/></a><?php } ?><br /><br /><br />
			<input type="file" id="fichier_fond" name="fichier_fond" onchange="visual_fond();" accept="image/*" hidden/>
			<img id="apercu_fond"/>
			<input type="hidden" id="fond_change" name="fond_change" value="0"/>
			<input type="file" id="fichier_avat" name="fichier_avat" onchange="visual_avatar();" accept="image/*"/>
			<input type="hidden" id="avatar_change" name="avatar_change" value="0"/>
		</form>
		<p id="texte_photo_profil">Photo de profil :</p>
		<img src="<?php echo htmlspecialchars($recherche['avatar']); ?>" onclick="changer_avatar();" alt="" id="avatar_apercu"/>
		<input type="button" value="Sauvegarder les modifications" id="sauvegarder_modif_compte" onclick="verif_modif();"/>
		<a href="a_propos.php" title="En savoir plus sur Witzing"><input type="button" value="En savoir plus sur Witzing" id="plus_witzing"/></a>
		<a href="cloturer_compte.php" title="Cliquer pour clôturer votre compte"><input type="button" value="Clôturer mon compte" id="cloturer_compte"/></a>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.js"></script>
</body>
</html>
