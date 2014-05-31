<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
if(isset($_GET['nom']))
{
	$req_info_membre_nom=$bdd->prepare('SELECT * FROM membres WHERE pseudo = :nom');
	$req_info_membre_nom->execute(array(
		'nom' => $_GET['nom'],
		));
	$info_membre_nom=$req_info_membre_nom->fetch();
	if($info_membre_nom)
	{
		header('Location: index.php?id=' . $info_membre_nom['id_membre']);
	}
	else
	{
		header('Location: recherche.php?recherche_cle=' . $_GET['nom']);
	}
	$req_info_membre_nom->closeCusor();
}
if(isset($_GET['id']) || isset($_GET['nom']))
{
	$_GET['id']=(int) $_GET['id'];
}
$req_info_membre=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
$req_info_membre->execute(array(
	'id' => $_GET['id'],
	));
$info_membre=$req_info_membre->fetch();
if($info_membre || isset($_GET['nom']))
{

}
else
{
	header('Location: index.php?id=' . $_SESSION['id_membre']);
}
$req_info_membre->closeCursor();
$attente_perso=explode('*', $info_membre['attente_amis']);
$amis_perso=explode('*', $info_membre['amis']);
$suiveur_perso=explode('*', $info_membre['suivis']);
$aime_perso=explode('*', $info_membre['aime']);
if(isset($_GET['aime_membre_id']) || isset($_GET['suivre_membre_id']))
{
	$req_info_id=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
	$req_info_id->execute(array(
		'id' => $_GET['id'],
		));
	$info_id=$req_info_id->fetch();
	if($info_id)
	{
		if(isset($_GET['aime_membre_id']))
		{
			$liste_actu=$aime_perso;
			$type_act='vous aime';
			$actu=$info_membre['aime'];
			$_GET['aime_membre_id']=(int) $_GET['aime_membre_id'];
			$req_faire='aime';
		}
		else
		{
			$liste_actu=$suiveur_perso;
			$type_act='s\'est abonné à vous !';
			$actu=$info_membre['suivis'];
			$_GET['suivre_membre_id']=(int) $_GET['suivre_membre_id'];
			$req_faire='suivis';
		}
		if($info_membre)
		{
			if(!(in_array($_SESSION['id_membre'], $liste_actu)))
			{
				$actu.='*' . $_SESSION['id_membre'] . '*';
				$maj_ancien=$bdd->prepare('UPDATE membres SET ' . $req_faire . ' = :chose WHERE id_membre = :id');
				$maj_ancien->execute(array(
					'id' => $_GET['id'],
					'chose' => $actu,
					));
				creer_notif($_GET['id'], 'index.php?id=' . $_GET['id'], $recherche['pseudo'] . ' ' . $type_act, $recherche['avatar']);
			}
			else
			{
				$actu=str_replace('*' . $_SESSION['id_membre'] . '*', '', $actu);
				$maj_ancien=$bdd->prepare('UPDATE membres SET ' . $req_faire . ' = :chose WHERE id_membre = :id');
				$maj_ancien->execute(array(
					'id' => $_GET['id'],
					'chose' => $actu,
					));
			}
		}
		header('Location: index.php?id=' . $_GET['id']);
	}
}
if(isset($_GET['amis_membre_id']) && $_GET['amis_membre_id']!=$_SESSION['id_membre'])
{
	$_GET['amis_membre_id']=(int) $_GET['amis_membre_id'];
	$req_info_id=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
	$req_info_id->execute(array(
		'id' => $_GET['id'],
		));
	$info_id=$req_info_id->fetch();
	if($info_id)
	{
		$req_info_amis=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
		$req_info_amis->execute(array(
			'id' => $_GET['amis_membre_id'],
			));
		$info_amis=$req_info_amis->fetch();
		if($info_amis)
		{
			if(in_array($_SESSION['id_membre'], $amis_perso))
			{
				$amis_liste_ancien=$info_membre['amis'];
				$amis_liste_ancien=str_replace('*' . $_SESSION['id_membre'] . '*', '', $amis_liste_ancien);
				$maj_amis=$bdd->prepare('UPDATE membres SET amis = :amis WHERE id_membre = :id');
				$maj_amis->execute(array(
					'id' => $_GET['amis_membre_id'],
					'amis' => $amis_liste_ancien,
					));
				$amis_liste_ancien_moi=$recherche['amis'];
				$amis_liste_ancien_moi=str_replace('*' . $_GET['amis_membre_id'] . '*', '', $amis_liste_ancien_moi);
				$maj_amis_moi=$bdd->prepare('UPDATE membres SET amis = :amis WHERE id_membre = :id');
				$maj_amis_moi->execute(array(
					'id' => $_SESSION['id_membre'],
					'amis' => $amis_liste_ancien_moi,
					));
				creer_notif($_GET['id'], 'index.php?id=' . $_GET['id'], $recherche['pseudo'] . ' n\'est plus votre amis', $recherche['avatar']);
				header('Location: index.php?id=' . $_GET['id']);
			}
			if(in_array($_SESSION['id_membre'], $attente_perso))
			{
				$attente_liste_ancien=$info_membre['attente_amis'];
				$attente_liste_ancien=str_replace('*' . $_SESSION['id_membre'] . '*', '', $attente_liste_ancien);
				$maj_attente=$bdd->prepare('UPDATE membres SET attente_amis = :attente WHERE id_membre = :id');
				$maj_attente->execute(array(
					'id' => $_GET['amis_membre_id'],
					'attente' => $attente_liste_ancien,
					));
				header('Location: index.php?id=' . $_GET['id']);
			}
			if(!(in_array($_SESSION['id_membre'], $attente_perso)) && !(in_array($_SESSION['id_membre'], $amis_perso)))
			{
				$demande_liste_ancien=$info_membre['attente_amis'];
				$demande_liste_ancien.='*' . $_SESSION['id_membre'] . '*';
				$maj_attente_moip=$bdd->prepare('UPDATE membres SET attente_amis = :attente WHERE id_membre = :id');
				$maj_attente_moip->execute(array(
					'id' => $_GET['amis_membre_id'],
					'attente' => $demande_liste_ancien,
					));
				header('Location: index.php?id=' . $_GET['id']);
			}
		}
	}
}
if(isset($_GET['notif_lus']))
{
	$_GET['notif_lus']= (int) $_GET['notif_lus'];
	$req_notif_lien=$bdd->prepare('SELECT * FROM notifications WHERE id_notif = :id AND membre_notif = :membre');
	$req_notif_lien->execute(array(
		'id' => $_GET['notif_lus'],
		'membre' => $_SESSION['id_membre'],
		));
	$notif_lien=$req_notif_lien->fetch();
	if($notif_lien)
	{
		$req_sup_notif=$bdd->prepare('DELETE FROM notifications WHERE membre_notif = :id_membre AND id_notif = :id');
		$req_sup_notif->execute(array(
			'id_membre' => $_SESSION['id_membre'],
			'id' => $_GET['notif_lus'],
		));
		if($notif_lien!='#')
		{
			header('Location: ' . $notif_lien['lien']);
		}
		else
		{
			header('Location: index.php?id=' . $_SESSION['id_membre']);
		}
	}
	$req_notif_lien->closeCursor();
}
$req_nmb_abonnements=$bdd->prepare('SELECT COUNT(*) AS nmb_abonnement FROM membres WHERE suivis REGEXP :id_membre AND id_membre != :id');
$req_nmb_abonnements->execute(array(
	'id_membre' => '\*' . $info_membre['id_membre'] . '\*',
	'id' => $info_membre['id_membre'],
	));
$nmb_abonnements=$req_nmb_abonnements->fetch();
if(isset($_GET['page']) && $_GET['page']>0)
{
	$limite_statut=(int) $_GET['page'];
}
else
{
	$limite_statut=5;
}
$req_nmb_abonnements->closeCursor();
if(isset($_GET['supr_membre']) && $recherche['admin']=='1')
{
	$req_recherche_mm=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
	$req_recherche_mm->execute(array(
		'id' => $_GET['supr_membre'],
		));
	$recherche_mm=$req_recherche_mm->fetch();
	$liste_demande_mm=explode('*', $recherche_mm['attente_amis']);
	$liste_amis_mm=explode('*', $recherche_mm['amis']);
	$liste_suiveur_mm=explode('*', $recherche_mm['suivis']);
	unlink($recherche_mm['avatar']);
	for($i=0;$i<count($liste_suiveur_mm);$i++)
	{
		if($liste_suiveur_mm[$i]!='')
		{
			creer_notif($liste_suiveur_mm[$i], 'index.php?id=' . $liste_suiveur_mm[$i], $recherche_mm['pseudo'] . ' vient de cloturer son compte', $recherche_mm['avatar']);
		}
	}
	for($i=0;$i<count($liste_amis_mm);$i++)
	{
		if($liste_amis_mm[$i]!='' && !(in_array($liste_amis_mm[$i], $liste_suiveur_mm)))
		{
			creer_notif($liste_amis_mm[$i], 'index.php?id=' . $liste_amis_mm[$i], $recherche_mm['pseudo'] . ' vient de cloturer son compte', $recherche_mm['avatar']);
		}
		if($liste_amis_mm[$i]!='')
		{
			$req_amis=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
			$req_amis->execute(array(
				'id_membre' => $liste_amis_mm[$i],
				));
			$amis=$req_amis->fetch();
			$supr_attente=$amis['attente_amis'];
			$supr_attente=str_replace('*' . $_GET['supr_membre'] . '*', '', $supr_attente);
			$maj_attentes=$bdd->prepare('UPDATE membres SET attente_amis = :supr WHERE id_membre = :id_membre');
			$maj_attentes->execute(array(
				'id_membre' => $liste_amis_mm[$i],
				'supr' => $supr_attente,
				));
			$supr_amis=$amis['amis'];
			$supr_amis=str_replace('*' . $_GET['supr_membre'] . '*', '', $supr_amis);
			$maj_amis=$bdd->prepare('UPDATE membres SET amis = :supr WHERE id_membre = :id_membre');
			$maj_amis->execute(array(
				'id_membre' => $liste_amis_mm[$i],
				'supr' => $supr_amis,
				));
			$req_amis->closeCursor();
		}
	}
	$req_abonnements=$bdd->prepare('SELECT * FROM membres WHERE suivis REGEXP :id_membre');
	$req_abonnements->execute(array(
		'id_membre' => '\*' . $_GET['supr_membre'] . '\*',
		));
	while($abonnements=$req_abonnements->fetch())
	{
		$supr_abon=$abonnements['suivis'];
		$supr_abon=str_replace('*' . $_GET['supr_membre'] . '*', '', $supr_abon);
		$maj_abon=$bdd->prepare('UPDATE membres SET suivis = :suivis WHERE id_membre = :id_membre');
		$maj_abon->execute(array(
			'id_membre' => $abonnements['id_membre'],
			'suivis' => $supr_abon,
			));
	}
	$req_abonnements->closeCursor();
	$req_aimes=$bdd->prepare('SELECT * FROM membres WHERE aime REGEXP :id_membre');
	$req_aimes->execute(array(
		'id_membre' => '\*' . $_GET['supr_membre'] . '\*',
		));
	while($aimes=$req_aimes->fetch())
	{
		$supr_aime=$aimes['aime'];
		$supr_aime=str_replace('*' . $_GET['supr_membre'] . '*', '', $supr_aime);
		$maj_aime=$bdd->prepare('UPDATE membres SET aime = :aime WHERE id_membre = :id_membre');
		$maj_aime->execute(array(
			'id_membre' => $aimes['id_membre'],
			'aime' => $supr_aime,
			));
	}
	$req_aimes->closeCursor();
	$req_supr_statut=$bdd->prepare('DELETE FROM statuts WHERE membre_statut = :id_membre');
	$req_supr_statut->execute(array(
		'id_membre' => $_GET['supr_membre'],
		));
	$req_supr_statut_autre=$bdd->prepare('DELETE FROM statuts WHERE ecrivain_statut = :id_membre');
	$req_supr_statut_autre->execute(array(
		'id_membre' => $_GET['supr_membre'],
		));
	$req_supr_aime_statut=$bdd->prepare('SELECT * FROM statuts WHERE aime_statut REGEXP :id_membre');
	$req_supr_aime_statut->execute(array(
		'id_membre' => '\*' . $_GET['supr_membre'] . '\*',
		));
	while($aime_statut=$req_supr_aime_statut->fetch())
	{
		$supr_aime_statut=$aime_statut['aime_statut'];
		$supr_aime_statut=str_replace('*' . $_GET['supr_membre'] . '*', '', $supr_aime_statut);
		$maj_aime_statut=$bdd->prepare('UPDATE statuts SET aime_statut = :aime_statut WHERE id_statut = :id_statut');
		$maj_aime_statut->execute(array(
			'id_statut' => $aime_statut['id_statut'],
			'aime_statut' => $supr_aime_statut,
			));
	}
	$req_supr_aime_statut->closeCursor();
	$req_supr_aime_pas_statut=$bdd->prepare('SELECT * FROM statuts WHERE aime_statut REGEXP :id_membre');
	$req_supr_aime_pas_statut->execute(array(
		'id_membre' => '\*' . $_GET['supr_membre'] . '\*',
		));
	while($aime_pas_statut=$req_supr_aime_pas_statut->fetch())
	{
		$supr_aime_pas_statut=$aime_pas_statut['aime_pas_statut'];
		$supr_aime_pas_statut=str_replace('*' . $_GET['supr_membre'] . '*', '', $supr_aime_pas_statut);
		$maj_aime_pas_statut=$bdd->prepare('UPDATE statuts SET aime_pas_statut = :aime_pas_statut WHERE id_statut = :id_statut');
		$maj_aime_pas_statut->execute(array(
			'id_statut' => $aime_pas_statut['id_statut'],
			'aime_pas_statut' => $supr_aime_pas_statut,
			));
	}
	$req_supr_aime_pas_statut->closeCursor();
	$req_membre_supr=$bdd->prepare('DELETE FROM membres WHERE id_membre = :id_membre');
	$req_membre_supr->execute(array(
		'id_membre' => $_GET['supr_membre'],
		));
	$req_supr_comment=$bdd->prepare('DELETE FROM comment_statuts WHERE id_auteur = :id_membre');
	$req_supr_comment->execute(array(
		'id_membre' => $_GET['supr_membre'],
		));
	header('Location: index.php');
}
if(isset($_POST['id_mm_badge']) && isset($_POST['createur_badge']))
{
	if($recherche['admin']=='1')
	{
		$nv_bdgs=$info_membre['badges'].='*' . $_POST['createur_badge'] . '*';
		$maj_compte=$bdd->prepare('UPDATE membres SET badges = :badges WHERE id_membre = :id_membre');
		$maj_compte->execute(array(
			'badges' => $nv_bdgs,
			'id_membre' => $_POST['id_mm_badge'],
			));
		creer_notif($info_membre['id_membre'], 'index.php?id=' . $info_membre['id_membre'], 'Vous-venez de recevoir un badge !', '../data/style/logo.png');
	}
}
$liste_badges=explode('*', $info_membre['badges']);
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Mon fil d'actu</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<?php
if($info_membre['theme_fil']!=0)
{
	echo '<link rel="stylesheet" href="../data/style/' . $theme_url[$info_membre['theme_fil']] . '"/>';
}
?>

<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body<?php if($info_membre['fond_fil']!='') { echo ' style="background-image: url(\'' . $info_membre['fond_fil'] . '\');"'; } ?>>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
	<?php include('../data/profil.php'); ?>
	<div id="conteneur_droite">
		<p id="pseudo_info"><a href="index.php?id=<?php echo $info_membre['id_membre']; ?>"><?php echo htmlspecialchars($info_membre['pseudo']); ?></a><img <?php if(membreconnecte($bdd, $_GET['id']) || $_GET['id']==$_SESSION['id_membre']) { echo 'src="../data/style/led1.png" title="Connecté"'; } else { echo 'src="../data/style/led0.png" title="Déconnecté"'; } ?> class="statut_con"/><?php if($recherche['admin']=='1') { ?><a href="javascript:;" onclick="if(confirm('Êtes-vous vraiment sûr de vouloir faire cela ?')) { resp_page('index.php?supr_membre=<?php echo htmlspecialchars($_GET['id']); ?>'); }" class="supr_compte_mm" title="Supprimer ce membre"> (supr)</a><?php } ?></p>
		<p id="bt_plus_info_mm"<?php if($info_membre['id_membre']==$_SESSION['id_membre']) { echo ' class="moi" '; } ?> onclick="plus_moins_info(<?php if($info_membre['id_membre']==$_SESSION['id_membre']) { echo 'true'; } ?>);">Plus d'informations +</p>
		<div id="boite_plus_info_mm">
			<p>Inscrit <?php $info_membre['date_inscription']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $info_membre['date_inscription']);echo $info_membre['date_inscription']; ?></p>
			<p>Dernière activité <?php $info_membre['derniere_activite']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $info_membre['derniere_activite']);echo $info_membre['derniere_activite']; ?></p>
			<p>Titre : <?php if($info_membre['admin']=='1') { echo 'Administrateur'; } else { echo 'Membre'; } ?></p>
			<p>Badges (<?php echo nombre_form($info_membre['badges']); ?>/<?php echo count($badges_nom); ?>) <br /><?php
			$arr=explode('*', $info_membre['badges']);
			for($i=0;$i<count($arr);$i++)
			{
				if($arr[$i]!='')
				{
					echo '<img src="../data/badges/' . $badges_url[$arr[$i]] . '" class="badge" title="' . $badges_nom[$arr[$i]] . '"/>';
				}
			}
			for($i=0;$i<count($badges_url);$i++)
			{
				if(!in_array($i, $arr))
				{
						echo '<img src="../data/badges/n_' . $badges_url[$i] . '" class="badge" title="' . $badges_nom[$i] . '"/>';
				}
			}
			?>
			<?php
			if($recherche['admin']=='1')
			{
				?>
				<form name="nv_bdg" method="post">
					<input type="text" placeholder="Attribuez-lui un badge ..." id="createur_badge" name="createur_badge"/>
					<input type="hidden" value="<?php echo $_GET['id']; ?>" name="id_mm_badge"/>
					<input type="submit" value="Appliquer" class="invisible"/>
				</form>
				<?php
			}
			?>
			</p>
		</div>
		<?php
		if($_GET['id']!=$_SESSION['id_membre'])
		{
		?>
		<div id="conteneur_social">
			<a href="?aime_membre_id=<?php echo $_GET['id']; ?>&amp;id=<?php echo $_GET['id']; ?>" class="aime_bt<?php if(in_array($_SESSION['id_membre'], $aime_perso)) { echo ' select_a'; } ?>"><span class="typo">l</span></a>
			<a href="?suivre_membre_id=<?php echo $_GET['id']; ?>&amp;id=<?php echo $_GET['id']; ?>" class="suivre_bt<?php if(in_array($_SESSION['id_membre'], $suiveur_perso)) { echo ' select_a'; } ?>">Abonné</a>
			<?php if(!in_array($_GET['id'], $liste_demande)) { ?><a href="?amis_membre_id=<?php echo $_GET['id']; ?>&amp;id=<?php echo $_GET['id']; ?>" class="amis_bt<?php if(in_array($_SESSION['id_membre'], $amis_perso)) { echo ' select_a'; } if(in_array($_SESSION['id_membre'], $attente_perso)) { echo ' select_b'; } ?>"><span class="typo">f</span></a><?php } ?>
			<?php if(in_array($_GET['id'], $liste_amis)) { ?><a href="messages.php?id=<?php echo $_GET['id']; ?>" class="msg_bt"><span class="typo">b</span></a><?php } ?>
		</div>
		<?php
		}
		?>
		<p id="monfil"><?php if($_GET['id']==$_SESSION['id_membre']) { ?>Mon fil d'actu <?php } else { ?>Fil d'actu <?php } ?></p>
		<?php
		if(in_array($_SESSION['id_membre'], $amis_perso) || $_GET['id']==$_SESSION['id_membre'] || $recherche['admin']=='1')
		{
		?>
		<div class="post ecriture_statut">
			<form method="post" id="post_form" enctype="multipart/form-data">
				<textarea name="post_text" id="post_text" maxlength="800" placeholder="Ecrivez sur <?php if($_GET['id']==$_SESSION['id_membre']) { echo 'votre fil d\'actu ...'; } else { echo 'le fil d\'actu de ' . $info_membre['pseudo'] . '...'; } ?>"></textarea>
				<input type="hidden" value="<?php echo $info_membre['id_membre'] ?>" name="destinataire"/>
				<input type="button" value="A" onclick="changer_photo_statut();" class="photo_post_bt"/>
				<input type="file" id="fichier_photo" name="fichier_photo" onchange="visual_photo_statut();" accept="image/*"/>
				<input type="hidden" id="photo_change" name="photo_change" value="0"/>
				<input type="button" value="Publier" onclick="verif_post();" class="publier_post"/>
			</form>
			<img src="" id="apercu_photo"/>
		</div>
		<?php
		}
		$test_statut=$bdd->prepare('SELECT COUNT(*) AS nmb_statut FROM statuts WHERE membre_statut = :membre ORDER BY id_statut DESC LIMIT 0, :limite');
		$test_statut->bindValue('membre', $_GET['id'], PDO::PARAM_INT);
		$test_statut->bindValue('limite', $limite_statut, PDO::PARAM_INT);
		$test_statut->execute();
		$test=$test_statut->fetch();
		if($test['nmb_statut']=='0')
		{
			?>
			<div class="post">
				<div class="contenu_post_edit">
					<p class="ouvrir_post"></p>
					<p class="date_createur_post"></p>
				</div>
				<p class="texte_nouveau_statut"><?php if($_GET['id']==$_SESSION['id_membre']) { echo 'Allez ' . htmlspecialchars($recherche['pseudo']) . ' ecrivez votre premier statut, c\'est facile !'; } else { echo 'Tiens donc, ' . htmlspecialchars($info_membre['pseudo']) . ' n\'a rien écrit ici ?'; } ?></p>
			</div>
			<?php
		}
		$test_statut->closeCursor();
		$req_status=$bdd->prepare('SELECT * FROM statuts WHERE membre_statut = :membre ORDER BY id_statut DESC LIMIT 0, :limite');
		$req_status->bindValue('membre', $_GET['id'], PDO::PARAM_INT);
		$req_status->bindValue('limite', $limite_statut, PDO::PARAM_INT);
		$req_status->execute();
		while($statuts=$req_status->fetch())
		{
			$req_membre_statut=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id_membre');
			$req_membre_statut->execute(array(
				'id_membre' => $statuts['ecrivain_statut'],
				));
			$membre_statut=$req_membre_statut->fetch();
			?>
			<div class="post">
				<div class="contenu_post_edit">
					<p class="ouvrir_post"><a href="lecture_post.php?id=<?php echo $statuts['id_statut']; ?>" title="Ouvrir le statut">Ouvrir le statut </a><span class="slash">/</span><?php if($statuts['ecrivain_statut']==$_SESSION['id_membre'] || $recherche['admin']=='1') { ?><a href="index.php?id_supr_post=<?php echo $statuts['id_statut']; ?>&amp;id=<?php echo $statuts['membre_statut']; ?>" class="supr_post" title="Supprimer le statut"> Supprimer le statut </a><?php } ?><?php if($statuts['ecrivain_statut']!=$_SESSION['id_membre']) { ?><a href="index.php?partager_post=<?php echo $statuts['id_statut']; ?>&amp;id=<?php echo $statuts['membre_statut']; ?>" title="Partager le statut"> Partager le statut <span class="typo">o</span></a><?php } ?></p>
					<?php
					if($statuts['partage']=='0')
					{
					?>
						<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> ';$statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
					<?php
					}
					else
					{
						$req_membre_partage=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
						$req_membre_partage->execute(array(
							'id_membre' => $statuts['partage'],
							));
						$membre_partage=$req_membre_partage->fetch();
					?>
						<p class="date_createur_post">Partagé par <?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> '; ?> de <a href="index.php?id=<?php echo $membre_partage['id_membre']; ?>">@<?php echo htmlspecialchars($membre_partage['pseudo']); ?></a> <?php $statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
					<?php
					}
					?>
				</div>
				<p class="texte_post_cont"><?php echo photo_statut(emoticons(linkeur(hashtageur(citeur_mm(nl2br(htmlspecialchars($statuts['contenu_statut']))))))); ?></p>
			</div>
			<?php
			$req_membre_statut->closeCursor();
		}
		$req_status->closeCursor();
		$limite_statut_plus=($limite_statut+5);
		if($limite_statut<$test['nmb_statut']) { ?><a href="index.php?id=<?php echo $_GET['id']; ?>&amp;page=<?php echo $limite_statut_plus; ?>#afficher_plus"><?php } ?><input type="button" <?php if($limite_statut>=$test['nmb_statut']) { ?>class="pas_afficher"<?php } ?> value="Afficher plus" id="afficher_plus"/><?php if($limite_statut<$test['nmb_statut']) { ?></a><?php } ?>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
</body>
</html>
