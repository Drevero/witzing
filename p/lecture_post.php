<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
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
<title>Witzing - Statut ouvert</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<?php
$_GET['id']=(int) $_GET['id'];
$req_membre_statut=$bdd->prepare('SELECT membre_statut FROM statuts WHERE id_statut = :id_statut');
$req_membre_statut->execute(array(
	'id_statut' => $_GET['id'],
	));
$membre_statut=$req_membre_statut->fetch();
$req_info_membre=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
$req_info_membre->execute(array(
	'id_membre' => $membre_statut['membre_statut'],
	));
$info_membre=$req_info_membre->fetch();
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
if($membre_statut)
{
	$req_status=$bdd->prepare('SELECT * FROM statuts WHERE id_statut = :membre');
	$req_status->execute(array(
		'membre' => $_GET['id'],
		));
	$statuts=$req_status->fetch();
	$liste_aime_statut=explode('*', $statuts['aime_statut']);
	$liste_aime_pas_statut=explode('*', $statuts['aime_pas_statut']);
	$req_membre=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id_membre');
	$req_membre->execute(array(
		'id_membre' => $statuts['ecrivain_statut'],
		));
	$membre=$req_membre->fetch();
	if(isset($_GET['aime']))
	{
		if(in_array($_SESSION['id_membre'], $liste_aime_statut))
		{
			$statuts['aime_statut']=str_replace('*' . $_SESSION['id_membre'] . '*', '', $statuts['aime_statut']);
			$maj_liste_aime=$bdd->prepare('UPDATE statuts SET aime_statut = :ancien WHERE id_statut = :id');
			$maj_liste_aime->execute(array(
				'ancien' => $statuts['aime_statut'],
				'id' => $_GET['id'],
				));
		}
		else
		{
			$statuts['aime_statut'].='*' . $_SESSION['id_membre'] . '*';
			$maj_liste_aime=$bdd->prepare('UPDATE statuts SET aime_statut = :ancien WHERE id_statut = :id');
			$maj_liste_aime->execute(array(
				'ancien' => $statuts['aime_statut'],
				'id' => $_GET['id'],
				));
			if($statuts['ecrivain_statut']!=$_SESSION['id_membre'])
			{
				creer_notif($statuts['ecrivain_statut'], 'lecture_post.php?id=' . $_GET['id'], $recherche['pseudo'] . ' aime votre publication !', $recherche['avatar']);
			}
		}
		header('Location: lecture_post.php?id=' . $_GET['id']);
	}
	if(isset($_GET['aime_pas']))
	{
		if(in_array($_SESSION['id_membre'], $liste_aime_pas_statut))
		{
			$statuts['aime_pas_statut']=str_replace('*' . $_SESSION['id_membre'] . '*', '', $statuts['aime_pas_statut']);
			$maj_liste_aime=$bdd->prepare('UPDATE statuts SET aime_pas_statut = :ancien WHERE id_statut = :id');
			$maj_liste_aime->execute(array(
				'ancien' => $statuts['aime_pas_statut'],
				'id' => $_GET['id'],
				));
		}
		else
		{
			$statuts['aime_pas_statut'].='*' . $_SESSION['id_membre'] . '*';
			$maj_liste_aime=$bdd->prepare('UPDATE statuts SET aime_pas_statut = :ancien WHERE id_statut = :id');
			$maj_liste_aime->execute(array(
				'ancien' => $statuts['aime_pas_statut'],
				'id' => $_GET['id'],
				));
			if($statuts['ecrivain_statut']!=$_SESSION['id_membre'])
			{
				creer_notif($statuts['ecrivain_statut'], 'lecture_post.php?id=' . $_GET['id'], $recherche['pseudo'] . ' n\'aime pas votre publication !', $recherche['avatar']);
			}
		}
		header('Location: lecture_post.php?id=' . $_GET['id']);
	}
	$req_status->closeCursor();
	$req_membre->closeCursor();
}
else
{
	header('Location: index.php ');
}
if(isset($_GET['supr_comment']))
{
	$_GET['supr_comment']=(int) $_GET['supr_comment'];
	$req_id_comment=$bdd->prepare('SELECT * FROM comment_statuts WHERE id_comment = :id_comment');
	$req_id_comment->execute(array(
		'id_comment' => $_GET['supr_comment'],
		));
	$id_comment_inf=$req_id_comment->fetch();
	if($id_comment_inf)
	{
		if($id_comment_inf['id_auteur']==$_SESSION['id_membre'] || $recherche['admin']=='1')
		{
			$req_supr_comment=$bdd->prepare('DELETE FROM comment_statuts WHERE id_comment = :id_comment');
			$req_supr_comment->execute(array(
				'id_comment' => $_GET['supr_comment'],
			));
			if(isset($_GET['id']))
			{
				header('Location: lecture_post.php?id=' . $_GET['id']);
			}
			else
			{
				header('Location: index.php?id=' . $_SESSION['id_membre']);
			}
		}
	}
}
$req_membre_statut->closeCursor();
$req_nmb_comment=$bdd->prepare('SELECT COUNT(*) AS nmb_comment FROM comment_statuts WHERE id_statut_comment = :id');
$req_nmb_comment->execute(array(
	'id' => $_GET['id'],
	));
$nmb_comment=$req_nmb_comment->fetch();
$req_nmb_abonnements=$bdd->prepare('SELECT COUNT(*) AS nmb_abonnement FROM membres WHERE suivis REGEXP :id_membre AND id_membre != :id');
$req_nmb_abonnements->execute(array(
	'id_membre' => '\*' . $info_membre['id_membre'] . '\*',
	'id' => $info_membre['id_membre'],
	));
$nmb_abonnements=$req_nmb_abonnements->fetch();
$req_sup_notif=$bdd->prepare('DELETE FROM notifications WHERE membre_notif = :id_membre AND lien = :lien');
$req_sup_notif->execute(array(
	'id_membre' => $_SESSION['id_membre'],
	'lien' => 'lecture_post.php?id=' . $_GET['id'],
));
?>
<div id="conteneur_membre">
	<?php include('../data/profil.php'); ?>
	<div id="conteneur_droite">
		<p id="pseudo_info"><a href="index.php?id=<?php echo $info_membre['id_membre']; ?>"><?php echo htmlspecialchars($info_membre['pseudo']); ?></a><img <?php if(membreconnecte($bdd, $info_membre['id_membre'])) { echo 'src="../data/style/led1.png" title="Connecté"'; } else { echo 'src="../data/style/led0.png" title="Déconnecté"'; } ?> class="statut_con"/></p>
		<p id="monfil">Statut ouvert</p>
		<div class="post">
			<div class="contenu_post_edit">
				<?php
				$liste_aime_statut=explode('*', $statuts['aime_statut']);
				$aime_statut_pseudo='';
				for($i=0;$i<count($liste_aime_statut) && $i<200;$i++)
				{
					if($liste_aime_statut[$i]!='')
					{
						$req_info_membre_aime=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id_membre');
						$req_info_membre_aime->execute(array(
							'id_membre' => $liste_aime_statut[$i],
							));
						$info_membre_aime=$req_info_membre_aime->fetch();
						if($i+2<count($liste_aime_statut))
						{
							$aime_statut_pseudo.=$info_membre_aime['pseudo'] . ', ';
						}
						else
						{
							$aime_statut_pseudo.=$info_membre_aime['pseudo'];
						}
						$req_info_membre_aime->closeCursor();
					}
				}
				if($aime_statut_pseudo=='')
				{
					$aime_statut_pseudo='Aucune personne n\'aime';
				}	
				else
				{
					$aime_statut_pseudo.=' aime';
				}
				$liste_aime_pas_statut=explode('*', $statuts['aime_pas_statut']);
				$aime_pas_statut_pseudo='';
				for($i=0;$i<count($liste_aime_pas_statut) && $i<200;$i++)
				{
					if($liste_aime_pas_statut[$i]!='')
					{
						$req_info_membre_aime_pas=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id_membre');
						$req_info_membre_aime_pas->execute(array(
							'id_membre' => $liste_aime_pas_statut[$i],
							));
						$info_membre_aime_pas=$req_info_membre_aime_pas->fetch();
						if($i+2<count($liste_aime_pas_statut))
						{
							$aime_pas_statut_pseudo.=$info_membre_aime_pas['pseudo'] . ', ';
						}
						else
						{
							$aime_pas_statut_pseudo.=$info_membre_aime_pas['pseudo'];
						}
						$req_info_membre_aime_pas->closeCursor();
					}
				}
				if($aime_pas_statut_pseudo=='')
				{
					$aime_pas_statut_pseudo='Aucune personne n\'aime pas';
				}	
				else
				{
					$aime_pas_statut_pseudo.=' n\'aime pas';
				}
				?>
				<p><a href="?id=<?php echo $statuts['id_statut']; ?>&amp;aime" title="<?php echo htmlspecialchars($aime_statut_pseudo); ?>"><span class="<?php if(in_array($_SESSION['id_membre'], $liste_aime_statut)) { echo 'actif_stat '; } ?>typo">l</span></a> <?php echo nombre_form($statuts['aime_statut']); ?><a href="?id=<?php echo $statuts['id_statut']; ?>&amp;aime_pas" title="<?php echo htmlspecialchars($aime_pas_statut_pseudo); ?>"><span class="<?php if(in_array($_SESSION['id_membre'], $liste_aime_pas_statut)) { echo 'actif_stat '; } ?>typo"> L</span></a> <?php echo nombre_form($statuts['aime_pas_statut']); ?> et <?php echo $nmb_comment['nmb_comment']; ?> commentaire<?php if($nmb_comment['nmb_comment']>1) { echo 's'; } ?></p>
				<?php
				if($statuts['partage']=='0')
				{
				?>
					<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre['pseudo']) . '</a> ';$statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
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
					<p class="date_createur_post">Partagé par <?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre['pseudo']) . '</a> '; ?> de <a href="index.php?id=<?php echo $membre_partage['id_membre']; ?>">@<?php echo htmlspecialchars($membre_partage['pseudo']); ?></a> <?php $statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
				<?php
				}
				?>
			</div>
			<p class="texte_post_cont"><?php echo photo_statut(emoticons(linkeur(citeur_mm(hashtageur(nl2br(htmlspecialchars($statuts['contenu_statut']))))))); ?></p>
		</div>
		<div class="plug_comment <?php if($nmb_comment['nmb_comment']==0) { echo 'videcomment'; } ?>">
			<?php
			$req_comment=$bdd->prepare('SELECT * FROM comment_statuts WHERE id_statut_comment = :id_statut ORDER BY id_comment DESC');
			$req_comment->execute(array(
				'id_statut' => $_GET['id'],
				));
			while($comment=$req_comment->fetch())
			{
				$req_info_membre_comment=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
				$req_info_membre_comment->execute(array(
					'id_membre' => $comment['id_auteur'],
					));
				$info_membre_comment=$req_info_membre_comment->fetch();
				$comment['date_comment']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $comment['date_comment']);
			?>
				<div class="comment_bulle">
					<a href="index.php?id=<?php echo $info_membre_comment['id_membre']; ?>"><img src="<?php echo htmlspecialchars($info_membre_comment['avatar']); ?>" title="L'auteur du commentaire est <?php echo htmlspecialchars($info_membre_comment['pseudo']); ?>" alt="avatar" class="avatar_comment"/></a>
					<span class="date_texte comment_date"><?php echo $comment['date_comment']; ?> <?php if($comment['id_auteur']==$_SESSION['id_membre'] || $recherche['admin']=='1') { ?><a href="lecture_post.php?id=<?php echo $_GET['id']; ?>&supr_comment=<?php echo $comment['id_comment']; ?>" title="Supprimer mon commentaire" class="supr_comment_moi"><span class="typo">I</span></a><?php } ?></span><br /><p><?php echo emoticons(linkeur(hashtageur(citeur_mm(htmlspecialchars($comment['comment']))))); ?><?php if($info_membre_comment['id_membre']!=$_SESSION['id_membre']) { ?><span class="repondre_membre typo" onclick="repondre_membre('<?php echo htmlspecialchars($info_membre_comment['pseudo']); ?>');"> o</span><?php } ?></p>
				</div>
			<?php
				$req_info_membre_comment->closeCursor();
			}
			$req_comment->closeCursor();
			?>
		</div>
		<div class="publicateur_comment <?php if($nmb_comment['nmb_comment']==0) { echo 'publicateur_vide'; } ?>">
			<form method="post" id="form_comment" onsubmit="verif_comment();return false;">
				<input type="text" maxlength="180" placeholder="Votre commentaire ..." class="input_comment" id="comment_input_text" name="commentaire"/>
				<input type="hidden" name="id_comment" value="<?php echo htmlspecialchars($_GET['id']); ?>"/>
				<img src="../data/emoticons/smile2.png" onclick="boite_smiley('comment_input_text');" id="bt_ouvrir_smilecomment"/>
				<input type="submit" class="bt_poster_comment" value="Poster"/>
			</form>
		</div>
		<?php
		$req_membre_statut->closeCursor();
		$req_info_membre->closeCursor();
		$req_nmb_comment->closeCursor();
		$req_nmb_abonnements->closeCursor();
		?>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
</body>
</html>
