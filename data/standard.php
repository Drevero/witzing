<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
$regex_hashtag='A-Z0-9éèàêëâä\-_à€';
$photos_url='';
$badges_url=array('beta-testeur.png', 'donateur.png', 'idees.png', 'inscrit.png', 'vacancier.png');
$badges_nom=array('L\'experimenteur, j\'ai participé à une session de bêta-test !', 'Le donateur, j\'ai réalisé un don à Witzing', 'La lumière, j\'ai donné des conseils pour Witzing', 'Le premier pas, je viens de m\'inscrire !', 'Le vacancier de retour, j\'ai passé 1 ans sans me connecter sur Witzing');
$theme_url=array('defaut', 'aero.css');
$theme_nom=array('Defaut', 'Aero (fond recommandé)');
$req_recherche=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
$req_recherche->execute(array(
	'id' => $_SESSION['id_membre'],
	));
$recherche=$req_recherche->fetch();
if(!$recherche)
{
	session_destroy();
	header('Location: ../index.php');
}
$liste_demande=explode('*', $recherche['attente_amis']);
$liste_amis=explode('*', $recherche['amis']);
$liste_suiveur=explode('*', $recherche['suivis']);
if(isset($_POST['commentaire']) && isset($_POST['id_comment']))
{
	if(strlen($_POST['commentaire'])>0 && strlen($_POST['commentaire'])<=180)
	{
		$_POST['id_comment']=(int) $_POST['id_comment'];
		$req_exi_statut=$bdd->prepare('SELECT * FROM statuts WHERE id_statut = :id');
		$req_exi_statut->execute(array(
			'id' => $_POST['id_comment'],
			));
		$statut_exi=$req_exi_statut->fetch();
		if($statut_exi)
		{
			$req_insert_notif=$bdd->prepare('INSERT INTO comment_statuts (id_auteur, id_statut_comment, comment) VALUES(:id_auteur, :id_statut_comment, :comment)');
			$req_insert_notif->execute(array(
				'id_auteur' => $_SESSION['id_membre'],
				'id_statut_comment' => $_POST['id_comment'],
				'comment' => $_POST['commentaire'],
				));
			if(preg_match('#@([' . $regex_hashtag . ']+)#i', $_POST['commentaire']))
			{
				$result_comment=preg_replace('#@([' . $regex_hashtag . ']+)#i', 'ø$0ø', $_POST['commentaire']);
				$citation_comment=explode('ø', $result_comment);
				for($i=0;$i<count($citation_comment);$i++)
				{
					if(preg_match('#@([' . $regex_hashtag . ']+)#i', $citation_comment[$i]))
					{
						$pseudo_comment=str_replace('@', '', $citation_comment[$i]);
						$req_mm_exi_comment=$bdd->prepare('SELECT id_membre FROM membres WHERE pseudo = :pseudo');
						$req_mm_exi_comment->execute(array(
							'pseudo' => $pseudo_comment,
							));
						$mm_exi_comment=$req_mm_exi_comment->fetch();
						if($mm_exi_comment && $mm_exi_comment['id_membre']!=$_SESSION['id_membre'])
						{
							creer_notif($mm_exi_comment['id_membre'], 'lecture_post.php?id=' . $_POST['id_comment'], $recherche['pseudo'] . ' vient de vous citer dans un commentaire !', $recherche['avatar']);
						}
					}
				}
			}
			if(!($statut_exi['ecrivain_statut']==$_SESSION['id_membre']))
			{
				creer_notif($statut_exi['ecrivain_statut'], 'lecture_post.php?id=' . $_POST['id_comment'], $recherche['pseudo'] . ' vient de commenter votre statut.', $recherche['avatar']);
			}
			header('Location: lecture_post.php?id=' . $_POST['id_comment']);
		}
	}
}
if(isset($_GET['dec']))
{
	$req_con=$bdd->prepare('UPDATE membres SET connecte = 0 WHERE id_membre = :id_membre');
	$req_con->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	session_destroy();
	header('Location: ../');
}
if(isset($_GET['id_supr_post']) && isset($_GET['id']))
{
	$_GET['id_supr_post']= (int) $_GET['id_supr_post'];
	if($recherche['admin']=='0')
	{
		$req_supr_post=$bdd->prepare('DELETE FROM statuts WHERE id_statut = :id_statut AND ecrivain_statut = :id_membre');
		$req_supr_post->execute(array(
			'id_membre' => $_SESSION['id_membre'],
			'id_statut' => $_GET['id_supr_post'],
		));
		$req_supr_post_comment=$bdd->prepare('DELETE FROM comment_statuts WHERE id_statut_comment = :id_statut');
		$req_supr_post_comment->execute(array(
			'id_statut' => $_GET['id_supr_post'],
		));
		$req_supr_post_notif=$bdd->prepare('DELETE FROM notifications WHERE lien = :lien');
		$req_supr_post_notif->execute(array(
			'lien' => 'lecture_post.php?id=' . $_GET['id_supr_post'],
		));
	}
	else
	{
		$req_supr_post=$bdd->prepare('DELETE FROM statuts WHERE id_statut = :id_statut');
		$req_supr_post->execute(array(
			'id_statut' => $_GET['id_supr_post'],
		));
		$req_supr_post_comment=$bdd->prepare('DELETE FROM comment_statuts WHERE id_statut_comment = :id_statut');
		$req_supr_post_comment->execute(array(
			'id_statut' => $_GET['id_supr_post'],
		));
		$req_supr_post_notif=$bdd->prepare('DELETE FROM notifications WHERE lien = :lien');
		$req_supr_post_notif->execute(array(
			'lien' => 'lecture_post.php?id=' . $_GET['id_supr_post'],
		));
	}
	header('Location: ../p/index.php?id=' . $_GET['id']);
}
if(isset($_GET['amis']) && isset($_GET['etat']))
{
	$_GET['amis']=(int) $_GET['amis'];
	if($recherche)
	{
		if(in_array($_GET['amis'], $liste_demande) && !in_array($_GET['amis'], $liste_amis))
		{
			$req_amis_autre=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
			$req_amis_autre->execute(array(
				'id_membre' => $_GET['amis'],
				));
			$amis_autre_res=$req_amis_autre->fetch();
			$amis=$recherche['amis'];
			$amis.='*' . $_GET['amis'] . '*';
			$amis_autre=$amis_autre_res['amis'];
			$amis_autre.='*' . $_SESSION['id_membre'] . '*';
			if($_GET['etat']=='accepter')
			{
				$maj_amis_autre=$bdd->prepare('UPDATE membres SET amis = :amis WHERE id_membre = :id_membre');
				$maj_amis_autre->execute(array(
					'id_membre' => $_GET['amis'],
					'amis' => $amis_autre,
					));
				$maj_amis=$bdd->prepare('UPDATE membres SET amis = :amis WHERE id_membre = :id_membre');
				$maj_amis->execute(array(
					'id_membre' => $_SESSION['id_membre'],
					'amis' => $amis,
					));
				$attente=$recherche['attente_amis'];
				$attente=str_replace('*' . $_GET['amis'] . '*', '', $attente);
				$maj_attente=$bdd->prepare('UPDATE membres SET attente_amis = :ancien WHERE id_membre = :id_membre');
				$maj_attente->execute(array(
					'id_membre' => $_SESSION['id_membre'],
					'ancien' => $attente,
					));
				creer_notif($_GET['amis'], 'index.php?id=' . $_SESSION['id_membre'], $recherche['pseudo'] . ' devient votre amis !', $recherche['avatar']);
			}
			else
			{
				$supr_attente=$recherche['attente_amis'];
				$supr_attente=str_replace('*' . $_GET['amis'] . '*', '', $supr_attente);
				$maj_attentes=$bdd->prepare('UPDATE membres SET attente_amis = :supr WHERE id_membre = :id_membre');
				$maj_attentes->execute(array(
					'id_membre' => $_SESSION['id_membre'],
					'supr' => $supr_attente,
					));
			}
		}
	}
}
function membreconnecte(PDO $pdo, $membre)
{
	$req_mm_co=$pdo->prepare('SELECT derniere_activite FROM membres WHERE id_membre = :id_membre');
	$req_mm_co->execute(array(
		'id_membre' => $membre,
		));
	$mm_co=$req_mm_co->fetch();
	$mm_co['derniere_activite']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'callback_mmco', $mm_co['derniere_activite']);
	return $mm_co['derniere_activite'];
}
function callback_mmco($matches)
{
	if($matches[3]==date('d') && $matches[2]==date('m') && $matches[1]=date('Y') && $matches[4]==date('H') && $matches[5]==date('i'))
	{
		return true;
	}
	else
	{
		if($matches[3]==date('d') && $matches[2]==date('m') && $matches[1]=date('Y') && $matches[4]==date('H') && $matches[5]==(date('i')-1))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
if(isset($_POST['post_text']) && isset($_POST['destinataire']) && isset($_FILES['fichier_photo']) && isset($_POST['photo_change']) && strlen($_POST['post_text'])<=900)
{
	$_POST['destinataire']=(int) $_POST['destinataire'];
	if(in_array($_POST['destinataire'], $liste_amis) || $_POST['destinataire']==$_SESSION['id_membre'] && strlen($_POST['post_text'])>0 || $recherche['admin']=='1')
	{
		if($_POST['photo_change']=='1')
		{
			if($_FILES['fichier_photo']['size']>2000000)
			{
			}
			else
			{
				if($_FILES['fichier_photo']['error']==0)
				{
					$inf_photo=pathinfo($_FILES['fichier_photo']['name']);
					$photo_ext=$inf_photo['extension'];
					$photo_ext_auto=array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
					if(in_array($photo_ext, $photo_ext_auto))
					{
						$nmb_al=mt_rand(0, 500);
						$urlimg='../p/statutp/' . 'p' . date('Y') . '' . date('m') . '' . date('d') . '' . date('H') . '' . date('i') . '' . date('s') . '' . $nmb_al . 'x.' . $inf_photo['extension'];
						$urlmini='../p/statutp/' . 'p' . date('Y') . '' . date('m') . '' . date('d') . '' . date('H') . '' . date('i') . '' . date('s') . '' . $nmb_al . 'x_mini.' . $inf_photo['extension'];
						move_uploaded_file($_FILES['fichier_photo']['tmp_name'], $urlimg);
						$propimg=getimagesize($urlimg);
						$largeur=$propimg[0];
						$hauteur=$propimg[1];
						$ratio=200/$largeur;
						if($largeur>200 || $hauteur>200)
						{
							$largeurfinale=ceil($largeur*$ratio);
							$hauteurfinale=ceil($hauteur*$ratio);
							redimmension_image($urlimg, $largeurfinale, $hauteurfinale, $urlmini, $inf_photo['extension']);
						}
						else
						{
							redimmension_image($urlimg, $largeur, $hauteur, $urlmini, $inf_photo['extension']);
						}
						$_POST['post_text'].='|~' . $urlimg . '~|';
					}
				}
			}
		}
		$req_insert_statut=$bdd->prepare('INSERT INTO statuts (membre_statut, ecrivain_statut, aime_statut, aime_pas_statut, contenu_statut) VALUES(:membre_statut, :ecrivain_statut, :aime, :aime_pas, :contenu_statut)');
		$req_insert_statut->execute(array(
			'membre_statut' => $_POST['destinataire'],
			'aime_pas' => '',
			'aime' => '',
			'ecrivain_statut' => $_SESSION['id_membre'],
			'contenu_statut' => $_POST['post_text'],
			));
		if(preg_match('#@([' . $regex_hashtag . ']+)#i', $_POST['post_text']))
		{
			$result=preg_replace('#@([' . $regex_hashtag . ']+)#i', 'ø$0ø', $_POST['post_text']);
			$citation=explode('ø', $result);
			for($i=0;$i<count($citation);$i++)
			{
				if(preg_match('#@([' . $regex_hashtag . ']+)#i', $citation[$i]))
				{
					$pseudo=str_replace('@', '', $citation[$i]);
					$req_mm_exi=$bdd->prepare('SELECT id_membre FROM membres WHERE pseudo = :pseudo');
					$req_mm_exi->execute(array(
						'pseudo' => $pseudo,
						));
					$mm_exi=$req_mm_exi->fetch();
					if($mm_exi && $mm_exi['id_membre']!=$_SESSION['id_membre'])
					{
						creer_notif($mm_exi['id_membre'], 'index.php?id=' . $_POST['destinataire'], $recherche['pseudo'] . ' vient de vous citer !', $recherche['avatar']);
					}
				}
			}
		}
		if($_POST['destinataire']!=$_SESSION['id_membre'])
		{
			creer_notif($_POST['destinataire'], 'index.php?id=' . $_POST['destinataire'], $recherche['pseudo'] . ' vient de publier sur votre fil d\'actu !', $recherche['avatar']);
		}
		for($i=0;$i<count($liste_suiveur);$i++)
		{
			if($liste_suiveur[$i]!='')
			{
				if($_POST['destinataire']==$_SESSION['id_membre'])
				{
					creer_notif($liste_suiveur[$i], 'index.php?id=' . $_POST['destinataire'], $recherche['pseudo'] . ' vient de publier un statut !', $recherche['avatar']);
				}
			}
		}
		header('Location: ../p/index.php?id=' . $_POST['destinataire']);
	}
}
if(isset($_GET['partager_post']) && isset($_GET['id']))
{
	$req_statut=$bdd->prepare('SELECT * FROM statuts WHERE id_statut = :id_statut');
	$req_statut->execute(array(
		'id_statut' => $_GET['partager_post'],
		));
	$statut=$req_statut->fetch();
	if($statut && $statut['ecrivain_statut']!=$_SESSION['id_membre'])
	{
		$req_insert_statut=$bdd->prepare('INSERT INTO statuts (membre_statut, ecrivain_statut, aime_statut, aime_pas_statut, contenu_statut, partage) VALUES(:membre_statut, :ecrivain_statut, :aime, :aime_pas, :contenu_statut, :partage)');
		$req_insert_statut->execute(array(
			'membre_statut' => $_SESSION['id_membre'],
			'aime_pas' => '',
			'aime' => '',
			'ecrivain_statut' => $_SESSION['id_membre'],
			'contenu_statut' => $statut['contenu_statut'],
			'partage' => $_GET['id'],
			));
		for($i=0;$i<count($liste_suiveur);$i++)
		{
			if($liste_suiveur[$i]!='')
			{
				creer_notif($liste_suiveur[$i], 'index.php?id=' . $_SESSION['id_membre'], $recherche['pseudo'] . ' vient de partager un statut', $recherche['avatar']);
			}
		}
		creer_notif($_GET['id'], 'index.php?id=' . $_SESSION['id_membre'], $recherche['pseudo'] . ' vient de partager votre statut', $recherche['avatar']);
	}
	header('Location: ../p/index.php?id=' . $_SESSION['id_membre']);
}
function nombre_form($chaine)
{
	$arr=explode('*', $chaine);
	$nmb=count($arr)/2-0.5;
	return $nmb;
}
function coupeur($chaine)
{
	if(strlen($chaine)>50)
	{
		$chaine_decomp=str_split($chaine);
		$prochaine_chaine='';
		for($i=0;$i<30;$i++)
		{
			$prochaine_chaine.=$chaine_decomp[$i];
		}
		return $prochaine_chaine . '...';
	}
	else
	{
		return $chaine;
	}
}
function hashtageur($hashtag)
{
	$regex_hashtag='A-Z0-9éèàêëâä\-_à€';
	$hashtag=preg_replace('#\#([' . $regex_hashtag . ']+)#i', '<a href="recherche.php?recherche_cle=$1&amp;interet" title="$1">$0</a>', $hashtag);
	return $hashtag;
}
function citeur_mm($cite)
{
	$regex_hashtag='A-Z0-9éèàêëâä\-_à€';
	$cite=preg_replace('#\@([' . $regex_hashtag . ']+)#i', '<a href="index.php?nom=$1" title="$1">$0</a>', $cite);
	return $cite;
}
function linkeur($lien)
{
	if(preg_match('#(png|PNG|gif|gif|JPG|jpg|jpeg|JPEG)#isU', $lien))
	{
		$lien=preg_replace('#(http|https)://(.+)$#isU', '<a href="javascript:;" onclick="lightbox(\'$0\', true);"><img src="$0" class="mini_img" title="$0"/></a>', $lien);
	}
	else
	{
		$lien=preg_replace('#(http|ftp|steam|https)://([A-Z0-9_-]+)(\.[a-z0-9]+){1,2}/?([A-Z0-9-/_\?=&;!\.]+)#i', '<a href="$0" title="$0">$0</a>', $lien);
	}
	return $lien;
}
function emoticons($texte)
{
	$liste_emoticons=Array('smile.png', 'sad.png', 'shock.png', 'embarrassed.png', 'good.png', 'laugh.png', 'love.png', 'mail.png', 'meeting.png', 'neutral.png', 'poop.png', 'present.png', 'quiet.png', 'rotfl.png', 'sick.png', 'sleepy.png', 'smile-big.png', 'sweat.png', 'tongue.png', 'victory.png', 'weep.png', 'wink.png', 'sun.png', 'question.png', 'bad.png', 'msn.png', 'car.png', 'knife.png', 'dog.png', 'beat-up.png', 'search.png', 'silly.png', 'shout.png', 'confused.png', 'party.png', 'worship.png', 'mad-tongue.png', 'musical-note.png', 'bashful.png', 'cat.png', 'sheep.png', 'msn-busy.png', 'star.png', 'angry.png', 'rose.png', 'desire.png', 'rain.png', 'beauty.png', 'goat.png', 'ghost.png', 'soldier.png', 'bomb.png', 'moon.png', 'doh.png', 'cloudy.png', 'struggle.png', 'go-away.png', 'island.png', 'devil.png', 'snail.png', 'rainbow.png', 'plate.png', 'in-love.png', 'call-me.png', 'eat.png', 'beer.png', 'boy.png', 'can.png', 'excruciating.png', 'jump.png', 'pizza.png', 'cake.png', 'curl-lip.png', 'drool.png', 'sigarette.png', 'hammer.png', 'pissed-off.png', 'eyeroll.png', 'secret.png', 'handcuffs.png', 'mean.png', 'monkey.png', 'vampire.png', 'terror.png', 'arrogant.png', 'camera.png', 'umbrella.png', 'skywalker.png', 'nailbiting.png', 'clover.png', 'bye.png', 'tv.png', 'disdain.png', 'kiss.png', 'cow.png', 'msn-away.png', 'lying.png', 'phone.png', 'airplane.png', 'glasses-nerdy.png', 'hug-left.png', 'waiting.png', 'hug-right.png', 'angel.png', 'act-up.png', 'clock.png', 'yin-yang.png', 'bowl.png', 'lashes.png', 'foot-in-mouth.png', 'girl.png', 'dance.png', 'doctor.png', 'clown.png', 'tremble.png', 'giggle.png', 'glasses-cool.png', 'chicken.png', 'sarcastic.png', 'peace.png', 'hypnotized.png', 'moneymouth.png', 'yawn.png', 'liquor.png', 'film.png', 'snowman.png', 'starving.png', 'drink.png', 'clap.png', 'snicker.png', 'skeleton.png', 'curse.png', 'msn_online.png', 'handshake.png', 'coffee.png', 'qq.png', 'lamp.png', 'blowkiss.png', 'rose-dead.png', 'soccerball.png', 'thunder.png', 'hungry.png', 'cowboy.png', 'brb.png', 'pray.png', 'disapointed.png', 'mobile.png', 'coins.png', 'shut-mouth.png', 'highfive.png', 'pill.png', 'alien.png', 'freaked-out.png', 'wilt.png', 'fingers-crossed.png', 'computer.png', 'console.png', 'smirk.png', 'pig.png', 'teeth.png', 'pumpkin.png', 'turtle.png', 'watermelon.png', 'cute.png', 'dazed.png', 'flag.png');
	$texte_emo=Array(':\)', ':\(', ':O', ':X', '\(y\)', 'xD', '&lt;3', ':mail:', ':meeting:', ':/ ', ':caca:', ':cadeau:', ':chut:', 'x\'D', ':malade:', ':dormir:', ':D', '--\'', ':P', '\\\o/', ':\'\(', ';\)', ':soleil:', ':hein:', '\(n\)', '\[\[msn\]\]', '\[\[voiture\]\]', '\[\[kanife\]\]', '\[\[chien\]\]', '\[\[ouch\]\]', '\[\[loupe\]\]', '\[\[ailleurs\]\]', '\[\[cri\]\]', '\[\[confus\]\]', '\[\[fete\]\]', '\[\[exercice\]\]', '\[\[moquerie\]\]', '\[\[musique\]\]', '\[\[repos\]\]', '\[\[chat\]\]', '\[\[chevre\]\]', '\[\[msnoccupe\]\]', '\[\[etoile\]\]', '\[\[enerve\]\]', '\[\[rose\]\]', '\*\.\*', '\[\[pluie\]\]', '\[\[beaute\]\]', '\[\[chevre2\]\]', '\[\[fantome\]\]', '\[\[soldat\]\]', '\[\[bombe\]\]', '\[\[lune\]\]', '\[\[doh\]\]', '\[\[nuageux\]\]', '\[\[pensif\]\]', '\[\[jereviens\]\]', '\[\[ile\]\]', '\[\[diable\]\]', '\[\[escargot\]\]', '\[\[arcenciel\]\]', '\[\[couvert\]\]', '\[\[coupdefoudre\]\]', '\[\[appellemoi\]\]', '\[\[manger\]\]', '\[\[biere\]\]', '\[\[homme\]\]', '\[\[canette\]\]', 'D:', '\[\[saut\]\]', '\[\[pizza\]\]', '\[\[gateau\]\]', '\[\[fausettes\]\]', '\[\[bave\]\]', '\[\[cigarette\]\]', '\[\[marteau\]\]', '\[\[nerf\]\]', '\[\[eyeroll\]\]', '\[\[secret\]\]', '\[\[menottes\]\]', '\[\[determine\]\]', '\[\[singe\]\]', '\[\[vampire\]\]', '\[\[terroriste\]\]', '\[\[arrogant\]\]', '\[\[camera\]\]', '\[\[parapluie\]\]', '\[\[pilote\]\]', '\[\[stress\]\]', '\[\[trefle\]\]', '\[\[bye\]\]', '\[\[tv\]\]', '\[\[moqueur\]\]', '\[\[bisous\]\]', '\[\[vache\]\]', '\[\[msnreviens\]\]', '\[\[menteur\]\]', '\[\[telephone\]\]', '\[\[avions\]\]', '\[\[intellectuel\]\]', '\[\[gauche\]\]', '\[\[patient\]\]', '\[\[droite\]\]', '\[\[ange\]\]', ':hap:', '\[\[heure\]\]', '\[\[yinyang\]\]', '\[\[riz\]\]', '\[\[cils\]\]', '\[\[piedsurbouche\]\]', '\[\[femme\]\]', '\[\[danse\]\]', '\[\[docteur\]\]', '\[\[clown\]\]', '\[\[tremble\]\]', '\[\[hihi\]\]', '\[\[cool\]\]', '\[\[poulet\]\]', '\[\[sarcastic\]\]', '\[\[paix\]\]', '\[\[hypnose\]\]', '\[\[argent\]\]', '\[\[baille\]\]', '\[\[liqueur\]\]', '\[\[film\]\]', '\[\[bonhommeneige\]\]', '\[\[faim\]\]', '\[\[boire\]\]', '\[\[applaudir\]\]', '\[\[clin\]\]', '\[\[squelette\]\]', '\[\[enerveplus\]\]', '\[\[msnenligne\]\]', '\[\[tchek\]\]', '\[\[cafe\]\]', '\[\[pinguin\]\]', '\[\[lampe\]\]', '\[\[douxbaiser\]\]', '\[\[rosemorte\]\]', '\[\[foot\]\]', '\[\[orage\]\]', '\[\[enerve3\]\]', '\[\[cowboy\]\]', '\[\[brb\]\]', '\[\[prier\]\]', '\[\[malenpoint\]\]', '\[\[mobile\]\]', '\[\[coints\]\]', '\[\[shadup\]\]', '\[\[tape5\]\]', '\[\[pillule\]\]', '\[\[alien\]\]', '\[\[enerve4\]\]', '\[\[timide\]\]', '\[\[croise\]\]', '\[\[ordinateur\]\]', '\[\[console\]\]', '\[\[smirk\]\]', '\[\[cochon\]\]', '\[\[dents\]\]', '\[\[halloween\]\]', '\[\[tortue\]\]', '\[\[melons\]\]', '\[\[meugnon\]\]', '\[\[dazed\]\]', '\[\[usa\]\]');
	for($i=0;$i<count($texte_emo);$i++)
	{
		$texte=preg_replace('#' . $texte_emo[$i] . '#isU', '<img src="../data/emoticons/' . $liste_emoticons[$i] . '" class="emoticons"/>', $texte);
	}
	return $texte;
}
function dateur($matches)
{
	$date_attr=false;
	if($matches[3]==date('d') && $matches[2]==date('m') && $matches[1]=date('Y'))
	{
		if($matches[4]==date('H') && $matches[5]!=date('i'))
		{
			if((date('i')-$matches[5])!=1)
			{
				return 'il y a ' . (date('i')-$matches[5]) . ' minutes';
			}
			else
			{
				return 'il y a 1 minute';
			}
		}
		else
		{
			if($matches[4]==date('H') && $matches[5]==date('i'))
			{
				return 'maintenant';
			}
			else
			{
				return 'aujourd\'hui à ' . $matches[4] . 'h' . $matches[5] . '';
			}
		}
		$date_attr=true;
	}
	if($matches[3]==(date('d')-1) && $matches[2]==date('m') && $matches[1]=date('Y'))
	{
		return 'hier à ' . $matches[4] . 'h' . $matches[5] . '';
		$date_attr=true;
	}
	if($matches[3]==(date('d')-2) && $matches[2]==date('m') && $matches[1]=date('Y'))
	{
		return 'avant-hier à ' . $matches[4] . 'h' . $matches[5] . '';
		$date_attr=true;
	}
	else
	{
		if($date_attr)
		{
		}
		else
		{
			return 'le ' . $matches[3] . '/' . $matches[2] . '/' . $matches[1] . ' à ' . $matches[4] . 'h' . $matches[5] . '';
		}
	}
}
function creer_notif($id_membre, $lien, $contenu, $avatar)
{
	global $bdd;
	$req_insert_notif_statut=$bdd->prepare('INSERT INTO notifications (membre_notif, contenu, lien, emetteur_notif, lu) VALUES(:membre_notif, :contenu, :lien, :emetteur_notif, 0)');
	$req_insert_notif_statut->execute(array(
		'membre_notif' => $id_membre,
		'lien' => $lien,
		'contenu' => $contenu,
		'emetteur_notif' => $_SESSION['id_membre'],
		));
}
function couper($chaine, $longueur)
{
	if(strlen($chaine)>$longueur)
	{
		return substr($chaine, 0, $longueur) . ' ...';
	}
	else
	{
		return $chaine;
	}
}
function photo_statut($chaine)
{
	$chainetest=preg_replace('#\|~\.\.\/p\/statutp\/(.+)\.(.+)~\|#isU', '|~../p/statutp/$1_mini.$2~|', $chaine);
	$fichier=explode('|~', $chainetest);
	if(!empty($fichier[1]))
	{
		$taille=strlen($fichier[1])-2;
		$fichierfin=substr($fichier[1], 0, $taille);
		if(file_exists($fichierfin))
		{
			$chaine=preg_replace('#\|~\.\.\/p\/statutp\/(.+)\.(.+)~\|#isU', '<a href="javascript:;" onclick="lightbox(\'../p/statutp/$1.$2\', true);" title="Photo"><img src="../p/statutp/$1_mini.$2" class="photo_statut"/></a>', $chaine);
		}
		else
		{
			$chaine=preg_replace('#\|~\.\.\/p\/statutp\/(.+)\.(.+)~\|#isU', '<a href="javascript:;" onclick="lightbox(\'../p/statutp/$1.$2\', true);" title="Photo"><img src="../p/statutp/$1.$2" class="photo_statut"/></a>', $chaine);
		}
	}
	else
	{
		$chaine=preg_replace('#\|~\.\.\/p\/statutp\/(.+)\.(.+)~\|#isU', '<a href="javascript:;" onclick="lightbox(\'../p/statutp/$1.$2\', true);" title="Photo"><img src="../p/statutp/$1_mini.$2" class="photo_statut"/></a>', $chaine);
	}
	return $chaine;
}
function photo_statut_desactiv($chaine)
{
	$chaine=preg_replace('#\|~(.+)~\|#isU', '[image]', $chaine);
	return $chaine;
}
?>
