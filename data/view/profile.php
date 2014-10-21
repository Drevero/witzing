<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
include('licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - <?php echo $name_profile; ?></title>
<link rel="stylesheet" href="data/style/style.php"/>
<?php
if($info_user['theme_fil']!=0)
{
	echo '<link rel="stylesheet" href="data/style/' . $theme_url[$info_user['theme_fil']] . '"/>';
}
?>

<link rel="icon" href="data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('data/view/bandeau.php');
?>
<div id="conteneur_membre">
	<div id="banner_member" style="background: url('<?php echo $info_user['fond_fil']; ?>');">
		<img src="<?php echo htmlspecialchars($info_user['avatar']); ?>" alt="avatar" id="avatar_banner"/>
		<p id="pseudo_info"><a href="index.php?id=<?php echo $info_membre['id_membre']; ?>"><?php echo htmlspecialchars($info_user['pseudo']); ?></a>
		<div id="content_social">
			<p id="social_markers"><a href="#"><?php echo count($abonnes); ?> abonné<?php if(count($abonnes)>1) { echo 's'; } ?></a><a href="#" class="space_btw_marker"><?php echo count($aime); ?> aime<?php if(count($aime)>1) { echo 'nt'; } ?></a><a href="#" class="space_btw_marker"><?php echo count($amis); ?> ami<?php if(count($amis)>1) { echo 's'; } ?></a><a href="#" class="space_btw_marker"><?php echo $mps; ?> message<?php if($mps>1) { echo 's'; } ?></a></p></div>
			<div id="social_buttons"><p id="friends_button" onclick="alert('caca');">f</p><div class="separator_band_buttons"></div><p id="follow_button">Je m'abonne</p></div>
		</div>
		<div class="title_content_ban whats_new">
			<p>Quoi de neuf ?</p>
		</div>
		<div id="write_post">
			<form method="post" id="post_form" enctype="multipart/form-data">
				<textarea name="post_text" id="post_text" maxlength="800" placeholder="Partagez vos envies, vos emotions ..."></textarea>
				<input type="hidden" value="<?php echo $info_user['id_membre'] ?>" name="destinataire"/>
				<input type="file" id="fichier_photo" name="fichier_photo" onchange="visual_photo_statut();" accept="image/*"/>
				<input type="hidden" id="photo_change" name="photo_change" value="0"/>
				<img src="" id="apercu_photo"/>
				<div id="options_post">
					<input type="button" value="A" onclick="changer_photo_statut();" class="photo_post_bt"/>
					<input type="button" value="Publier" onclick="verif_post();" class="publier_post"/>
				</div>
			</form>
		</div>
		<?php
		$status=getUserStatus($_GET['id'], $limit=10, $bdd);
		for($i=0;$i<count($status);$i++)
		{
			$likes_stats=unserialize($status[$i]['aime_statut']);
			$notlikes_stats=unserialize($status[$i]['aime_pas_statut']);
			$member_status=getUserInfo($status[$i]['ecrivain_statut'], $bdd);
			?>
		<div class="post" id="post<?php echo $status[$i]['id_statut']; ?>">
			<div class="title_content_ban post_ban">
				<img src="<?php echo htmlspecialchars($member_status['avatar']); ?>"/>
				<p class="author"><?php echo htmlspecialchars($member_status['pseudo']); ?></p>
				<p class="date"><?php $status[$i]['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $status[$i]['date_statut']);echo $status[$i]['date_statut']; ?></p>
				<p class="trash_post" onclick="supr_post('<?php echo $status[$i]['id_statut']; ?>');">I</p>
			</div>
			<div class="content_post">
				<p><?php echo markdown(photo_statut(emoticons(linkeur(embed(hashtageur(citeur_mm(nl2br(htmlspecialchars($status[$i]['contenu_statut']))))))))); ?></p>
			</div>
		</div>
		<?php
		}
		?>
		<?php /*
		<p id="bt_plus_info_mm"<?php if($info_user['id_membre']==$_SESSION['id_membre']) { echo ' class="moi" '; } ?> onclick="plus_moins_info(<?php if($info_user['id_membre']==$_SESSION['id_membre']) { echo 'true'; } ?>);">Plus d'informations +</p>
		<div id="boite_plus_info_mm">
			<p>Inscrit <?php $info_user['date_inscription']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $info_user['date_inscription']);echo $info_user['date_inscription']; ?></p>
			<p>Dernière activité <?php $info_membre['derniere_activite']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $info_user['derniere_activite']);echo $info_user['derniere_activite']; ?></p>
			<p>Titre : <?php if($info_user['admin']=='1') { echo 'Administrateur'; } else { echo 'Membre'; } ?></p>
			<p>Badges (<?php echo count($badges_me); ?>/<?php echo count($badges_nom); ?>) <br /><?php
			for($i=0;$i<count($badges_me);$i++)
			{
				echo '<img src="data/img/badges/' . $badges_url[$badges_me[$i]] . '" class="badge" title="' . $badges_nom[$badges_me[$i]] . '"/>';
			}
			for($i=0;$i<count($badges);$i++)
			{
				if(!in_array($i, $badges_me))
				{
					echo '<img src="data/img/badges/n_' . $badges_url[$i] . '" class="badge" title="' . $badges_nom[$i] . '"/>';
				}
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
			<?php if(ismyFriend($_GET['id'], $bdd)) { ?><a href="messages.php?id=<?php echo $_GET['id']; ?>" class="msg_bt"><span class="typo">b</span></a><?php } ?>
		</div>
		<?php
		}
		?>
		<p id="monfil"><?php if($_GET['id']==$_SESSION['id_membre']) { ?>Mon fil d'actu <?php } else { ?>Fil d'actu <?php } ?></p>
		<?php
		if(ismyFriend($_GET['id'], $bdd) || $_GET['id']==$_SESSION['id_membre'] || admin_check($bdd))
		{
		?>
		<div class="post ecriture_statut">
			<form method="post" id="post_form" enctype="multipart/form-data">
				<textarea name="post_text" id="post_text" maxlength="800" placeholder="Ecrivez sur <?php if($_GET['id']==$_SESSION['id_membre']) { echo 'votre fil d\'actu ...'; } else { echo 'le fil d\'actu de ' . htmlspecialchars($info_user['pseudo']) . '...'; } ?>"></textarea>
				<img src="../data/emoticons/smile2.png" onclick="boite_smiley('post_text');" id="bt_ouvrir_smilestatut"/>
				<input type="hidden" value="<?php echo $info_user['id_membre'] ?>" name="destinataire"/>
				<input type="button" value="A" onclick="changer_photo_statut();" class="photo_post_bt"/>
				<input type="file" id="fichier_photo" name="fichier_photo" onchange="visual_photo_statut();" accept="image/*"/>
				<input type="hidden" id="photo_change" name="photo_change" value="0"/>
				<input type="button" value="Publier" onclick="verif_post();" class="publier_post"/>
			</form>
			<img src="" id="apercu_photo"/>
		</div>
		<?php
		}
		?>
		<?php
		$status=getUserStatus($_GET['id'], $limit=10, $bdd);
		for($i=0;$i<count($status);$i++)
		{
			$likes_stats=unserialize($status[$i]['aime_statut']);
			$notlikes_stats=unserialize($status[$i]['aime_pas_statut']);
			?>
			<div class="post" id="post<?php echo $status[$i]['id_statut']; ?>">
				<div class="contenu_post_edit">
					<p class="ouvrir_post"><span class="typo click<?php if(in_array($_SESSION['id_membre'], $likes_stats)) { echo ' use'; } ?>" id="like_stats<?php echo $status[$i]['id_statut']; ?>" onclick="like_stats('<?php echo $status[$i]['id_statut'] ?>');">l</span> <span class="text_like" id="text_like<?php echo $status[$i]['id_statut']; ?>"><?php echo count($likes_stats); ?></span> <span class="typo click" id="notlike_stats<?php echo $status[$i]['id_statut']; ?>" onclick="unlike_stats('<?php echo $status[$i]['id_statut'] ?>');">L</span> <span class="text_like" id="notlike_text<?php echo $status[$i]['id_statut']; ?>"><?php echo count($notlikes_stats); ?></span><?php if($status[$i]['ecrivain_statut']==$_SESSION['id_membre'] || $recherche['admin']=='1') { ?><span onclick="supr_post('<?php echo $status[$i]['id_statut']; ?>');" class="supr_post click" title="Supprimer le statut"> Supprimer le statut</a><?php } ?><?php if($status[$i]['ecrivain_statut']!=$_SESSION['id_membre']) { ?><a href="index.php?partager_post=<?php echo $status[$i]['id_statut']; ?>&amp;id=<?php echo $status[$i]['membre_statut']; ?>" title="Partager le statut"> Partager le statut <span class="typo">o</span></a><?php } ?></p>
					<?php
					if($status[$i]['partage']=='0')
					{
					?>
						<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $status[$i]['ecrivain_statut'] . '">@' . htmlspecialchars(member_name($status[$i]['ecrivain_statut'], $bdd)) . '</a> ';$status[$i]['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $status[$i]['date_statut']);echo $status[$i]['date_statut']; ?></p>
					<?php
					}
					else
					{
						// FIX ~ Fonction partage non fonctionnelle
					?>
						<p class="date_createur_post">Partagé par <?php echo '<a href="index.php?id=' . $status[$i]['ecrivain_statut'] . '">@' . htmlspecialchars(member_name($status[$i]['membre_statut'], $bdd)) . '</a> '; ?> de <a href="index.php?id=<?php echo $membre_partage['id_membre']; ?>">@<?php echo htmlspecialchars($membre_partage['pseudo']); ?></a> <?php $status[$i]['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $status[$i]['date_statut']);echo $status[$i]['date_statut']; ?></p>
					<?php
					}
					?>
				</div>
				<p class="texte_post_cont"><?php echo markdown(photo_statut(emoticons(linkeur(embed(hashtageur(citeur_mm(nl2br(htmlspecialchars($status[$i]['contenu_statut']))))))))); ?></p>
			</div>
			<?php
		} */
		?>
</div>
<script type="text/javascript" src="data/witzing.php"></script>
</body>
</html>
