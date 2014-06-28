<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
header('Content-type: text/xml');
session_start();
include('bdd.php');
include('standard.php');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<corp>';
if(!(isset($_SESSION['id_membre'])) || !(isset($_GET['req'])) && !(isset($_POST['message'])))
{
	header('Location: ../index.php');
}
if($_GET['req']=='vider_message')
{
	$req_lus=$bdd->prepare('UPDATE messages_perso SET lu = 1 WHERE lu = 0 AND salon REGEXP :salon AND id_auteur != :id_membre');
	$req_lus->execute(array(
		'salon' => '\*' . $_SESSION['id_membre'] . '\*',
		'id_membre' => $_SESSION['id_membre'],
	));
}
if($_GET['req']=='vider_notif')
{
	$req_supr_notif=$bdd->prepare('DELETE FROM notifications WHERE membre_notif = :id_membre');
	$req_supr_notif->execute(array(
		'id_membre' => $_SESSION['id_membre'],
	));
}
if($_GET['req']=='nmb_mm_co')
{
	$req_nmb_co=$bdd->query('SELECT * FROM membres WHERE derniere_activite >= \'' . date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H') . ':' . (date('i')-1) . ':00\' AND id_membre != ' . $_SESSION['id_membre'] . '');
	while($nmb_co=$req_nmb_co->fetch())
	{
		if(in_array($nmb_co['id_membre'], $liste_amis))
		{
			echo '<membre pseudo="' . htmlspecialchars($nmb_co['pseudo']) . '" avatar="' . $nmb_co['avatar'] . '" discution="' . $nmb_co['id_membre'] . '"/>';
		}
	}
}
if($_GET['req']=='nmb_inscr_co')
{
	$req_nmb_co=$bdd->query('SELECT COUNT(*) AS nmb_co FROM membres WHERE derniere_activite >= \'' . date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H') . ':' . (date('i')-1) . ':00\'');
	$nmb_co=$req_nmb_co->fetch();
	$req_nmb_inscr=$bdd->query('SELECT COUNT(*) AS nmb_inscr FROM membres');
	$nmb_inscr=$req_nmb_inscr->fetch();
	echo '<nombre inscrit="' . $nmb_inscr['nmb_inscr'] . '" connecte="' . $nmb_co['nmb_co'] . '"/>';
}
if($_GET['req']=='demande_ami')
{

}
if($_GET['req']=='recherche_membre')
{
	if(isset($_GET['rech']))
	{
		$recherche_regex=preg_replace('#\(#isU', '\(', $_GET['rech']);
		$recherche_regex=preg_replace('#\)#isU', '\)', $_GET['rech']);
		$recherche_regex=preg_replace('#\(#isU', '\(', $_GET['rech']);
		$recherche_regex=preg_replace('#\.#isU', '\.', $_GET['rech']);
		$test_req=$bdd->prepare('SELECT * FROM membres WHERE pseudo REGEXP :recherche ORDER BY id_membre DESC LIMIT 0, 5');
		$test_req->execute(array(
			'recherche' => $recherche_regex,
			));
		$test=$test_req->fetch();
		$recherche_req=$bdd->prepare('SELECT * FROM membres WHERE pseudo REGEXP :recherche ORDER BY id_membre DESC LIMIT 0, 5');
		$recherche_req->execute(array(
			'recherche' => $recherche_regex,
			));
		if($test)
		{
			while($recherche=$recherche_req->fetch())
			{
				echo '<membre pseudo="' . htmlspecialchars($recherche['pseudo']) . '" id_membre="' . $recherche['id_membre'] . '" avatar="' . $recherche['avatar'] . '"/>';
			}
		}
		else
		{
		}
	}
}
if($_GET['req']=='notif')
{
	$req_nmb_notif=$bdd->prepare('SELECT COUNT(*) AS nmb_msg FROM messages_perso WHERE lu = 0 AND salon REGEXP :salon_id AND id_auteur != :auteur');
	$req_nmb_notif->execute(array(
		'salon_id' => '\*' . $_SESSION['id_membre'] . '\*',
		'auteur' => $_SESSION['id_membre'],
		));
	$nmb_notif=$req_nmb_notif->fetch();
	echo '<nombremp valeur="' . $nmb_notif['nmb_msg'] . '"/>';
	$req_nmb_notif->closeCursor();
	$req_notif=$bdd->prepare('SELECT * FROM messages_perso WHERE lu = 0 AND salon REGEXP :salon_id AND id_auteur != :auteur ORDER BY id_message DESC');
	$req_notif->execute(array(
		'salon_id' => '\*' . $_SESSION['id_membre'] . '\*',
		'auteur' => $_SESSION['id_membre'],
		));
	while($notif=$req_notif->fetch())
	{
		$array_perso=explode('*', $notif['salon']);
		$perso='';
		if($array_perso[1]==$_SESSION['id_membre'])
		{
			$perso=$array_perso[2];
		}
		else
		{
			$perso=$array_perso[1];
		}
		$req_auteur=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_auteur');
		$req_auteur->execute(array(
			'id_auteur' => $notif['id_auteur'],
			));
		$auteur=$req_auteur->fetch();
		$notif['contenu']=str_replace('<', ' ', $notif['contenu']);
		$notif['contenu']=str_replace('>', ' ', $notif['contenu']);
		echo '<message lien="messages.php?id=' . $perso . '" contenu="' . htmlspecialchars(couper($notif['contenu'], 30)) . '" avatar="' . htmlspecialchars($auteur['avatar']) . '"/>';
		$req_auteur->closeCursor();
	}
	$req_notif->closeCursor();
	$req_nmb_notif->closeCursor();
	$req_nmb_notif=$bdd->prepare('SELECT COUNT(*) AS nmb_notif FROM notifications WHERE membre_notif = :id_membre AND lu = 0');
	$req_nmb_notif->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	$nmb_notif=$req_nmb_notif->fetch();
	echo '<nombrenot valeur="' . $nmb_notif['nmb_notif'] . '"/>';
	$req_nmb_notif->closeCursor();
	$req_notif=$bdd->prepare('SELECT * FROM notifications WHERE membre_notif = :id_membre AND lu = 0 ORDER BY id_notif DESC');
	$req_notif->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	while($notif=$req_notif->fetch())
	{
		$req_mmnotif=$bdd->prepare('SELECT avatar FROM membres WHERE id_membre = :id_membre');
		$req_mmnotif->execute(array(
			'id_membre' => $notif['emetteur_notif'],
			));
		$mmnotif=$req_mmnotif->fetch();
		echo '<notification lien="index.php?notif_lus=' . $notif['id_notif'] . '" contenu="' . htmlspecialchars($notif['contenu']) . '" avatar="' . $mmnotif['avatar'] . '" id="' . $notif['id_notif'] . '"/>';
		$req_mmnotif->closeCursor();
	}
	$req_notif->closeCursor();
	$maj_compte=$bdd->prepare('UPDATE membres SET derniere_activite = NOW() WHERE id_membre = :id_membre');
	$maj_compte->execute(array(
	'id_membre' => $_SESSION['id_membre'],
	));
	$req_demande=$bdd->prepare('SELECT attente_amis FROM membres WHERE id_membre = :id_membre');
	$req_demande->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	$demande=$req_demande->fetch();
	if($demande)
	{
		$liste_demande=explode('*', $demande['attente_amis']);
		$nmb_demande=count($liste_demande)/2-0.5;
	}
	$req_demande->closeCursor();
	echo '<nombredmd valeur="' . $nmb_demande . '"/>';
	for($i=0;$i<count($liste_demande);$i++)
	{
		if($liste_demande[$i]!='')
		{
			$req_amis=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
			$req_amis->execute(array(
				'id' => $liste_demande[$i],
				));
			$amis=$req_amis->fetch();
			echo '<demande pseudo="' . htmlspecialchars($amis['pseudo']) . '" avatar="' . $amis['avatar'] . '" id="' . $amis['id_membre'] . '"/>';
			$req_amis->closeCursor();
		}
	}
}
if(isset($_POST['message']) && strlen($_POST['message'])<=600 && isset($_POST['salon']))
{
	$liste_perso=explode('*', $_GET['salon_id']);
	$perso='';
	if($liste_perso[1]==$_SESSION['id_membre'])
	{
		$perso=$liste_perso[2];
	}
	else
	{
		$perso=$liste_perso[1];
	}
	if(!in_array($perso, $liste_amis) || !in_array($_SESSION['id_membre'], $liste_perso))
	{
		header('Location: ../index.php');
	}
	$req_insert_msg=$bdd->prepare('INSERT INTO messages_perso (id_auteur, salon, lu, contenu) VALUES(:id_auteur, :salon, :lu, :contenu)');
	$req_insert_msg->execute(array(
		'id_auteur' => $_SESSION['id_membre'],
		'salon' => $_POST['salon'],
		'lu' => '0',
		'contenu' => $_POST['message'],
		));
	$req_clavier=$bdd->prepare('DELETE FROM au_clavier WHERE id_membre = :id_membre AND salon = :salon');
	$req_clavier->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		'salon' => $_POST['salon'],
	));
}
if(isset($_POST['message_salon']) && strlen($_POST['message_salon'])<=600)
{
	$req_insert_msg=$bdd->prepare('INSERT INTO salon (id_auteur, contenu_message) VALUES(:id_auteur, :contenu)');
	$req_insert_msg->execute(array(
		'id_auteur' => $_SESSION['id_membre'],
		'contenu' => $_POST['message_salon'],
		));
}
if($_GET['req']=='msg_lu' && isset($_GET['salon_id']))
{
	$liste_perso=explode('*', $_GET['salon_id']);
	$perso='';
	if($liste_perso[1]==$_SESSION['id_membre'])
	{
		$perso=$liste_perso[2];
	}
	else
	{
		$perso=$liste_perso[1];
	}
	if(!in_array($perso, $liste_amis))
	{
		header('Location: ../index.php');
	}
	$req_lus=$bdd->prepare('UPDATE messages_perso SET lu = 1 WHERE lu = 0 AND salon = :salon AND id_auteur != :id_membre');
	$req_lus->execute(array(
		'salon' => $_GET['salon_id'],
		'id_membre' => $_SESSION['id_membre'],
	));
}
if($_GET['req']=='clavier_true' && isset($_GET['salon_id']))
{
	$liste_perso=explode('*', $_GET['salon_id']);
	$perso='';
	if($liste_perso[1]==$_SESSION['id_membre'])
	{
		$perso=$liste_perso[2];
	}
	else
	{
		$perso=$liste_perso[1];
	}
	if(!in_array($perso, $liste_amis))
	{
		header('Location: ../index.php');
	}
	$req_clavier=$bdd->prepare('INSERT INTO au_clavier (id_membre, salon) VALUES(:id_membre, :salon)');
	$req_clavier->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		'salon' => $_GET['salon_id'],
	));
}
if($_GET['req']=='clavier_false' && isset($_GET['salon_id']))
{
	$liste_perso=explode('*', $_GET['salon_id']);
	$perso='';
	if($liste_perso[1]==$_SESSION['id_membre'])
	{
		$perso=$liste_perso[2];
	}
	else
	{
		$perso=$liste_perso[1];
	}
	if(!in_array($perso, $liste_amis))
	{
		header('Location: ../index.php');
	}
	$req_clavier=$bdd->prepare('DELETE FROM au_clavier WHERE id_membre = :id_membre AND salon = :salon');
	$req_clavier->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		'salon' => $_GET['salon_id'],
	));
}
if($_GET['req']=='msg_salon' && isset($_GET['salon_id']))
{
	$req_messages=$bdd->prepare('SELECT * FROM messages_perso WHERE salon = :id_salon ORDER BY id_message DESC LIMIT 0, 4');
	$req_messages->execute(array(
		'id_salon' => $_GET['salon_id'],
		));
	$liste_perso=explode('*', $_GET['salon_id']);
	$perso='';
	if($liste_perso[1]==$_SESSION['id_membre'])
	{
		$perso=$liste_perso[2];
	}
	else
	{
		$perso=$liste_perso[1];
	}
	if(!in_array($perso, $liste_amis) || !in_array($_SESSION['id_membre'], $liste_perso))
	{
		header('Location: ../index.php');
	}
	$req_lu=$bdd->prepare('SELECT lu FROM messages_perso WHERE salon = :id_salon ORDER BY id_message DESC');
	$req_lu->execute(array(
		'id_salon' => $_GET['salon_id'],
		));
	$msg_lu=$req_lu->fetch();
	if($msg_lu['lu']=='1')
	{
		echo '<lu valeur="1"/>';
	}
	else
	{
		echo '<lu valeur="0"/>';
	}
	$req_lu->closeCursor();
	$req_clavier=$bdd->prepare('SELECT * FROM au_clavier WHERE salon = :id_salon AND id_membre != :id_membre');
	$req_clavier->execute(array(
		'id_salon' => $_GET['salon_id'],
		'id_membre' => $_SESSION['id_membre'],
		));
	$clavier=$req_clavier->fetch();
	$req_membre_clavier=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_auteur');
	$req_membre_clavier->execute(array(
		'id_auteur' => $clavier['id_membre'],
		));
	$membre_clavier=$req_membre_clavier->fetch();
	if($clavier)
	{
		echo '<clavier valeur="1" pseudo="' . htmlspecialchars($membre_clavier['pseudo']) . '"/>';
	}
	else
	{
		echo '<clavier valeur="0"/>';
	}
	$req_membreco=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
	$req_membreco->execute(array(
		'id_membre' => $perso,
		));
	$membreco=$req_membreco->fetch();
	if(membreconnecte($bdd, $membreco['id_membre']))
	{
		echo '<connecte valeur="1"/>';
	}
	else
	{
		echo '<connecte valeur="0"/>';
	}
	while($messages=$req_messages->fetch())
	{
		$req_auteur=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_auteur');
		$req_auteur->execute(array(
			'id_auteur' => $messages['id_auteur'],
			));
		$auteur=$req_auteur->fetch();
		$messages['contenu']=str_replace('<', '&lt;', $messages['contenu']);
		$messages['contenu']=str_replace('>', '&gt;', $messages['contenu']);
		$messages['date_message']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $messages['date_message']);
		if($messages['id_auteur']!=$_SESSION['id_membre'])
		{
			echo '<message date="' . $messages['date_message'] . '" avatar="' . $auteur['avatar'] . '" id_auteur="' . $messages['id_auteur'] . '" contenu="' . htmlspecialchars(emoticons(linkeur(citeur_mm(hashtageur($messages['contenu']))))) . '" align="droite"/>';
		}
		else
		{
			echo '<message date="' . $messages['date_message'] . '" avatar="' . $auteur['avatar'] . '" id_auteur="' . $messages['id_auteur'] . '" contenu="' . htmlspecialchars(emoticons(linkeur(citeur_mm(hashtageur($messages['contenu']))))) . '" align="gauche"/>';
		}
		$req_auteur->closeCursor();
	}
	$req_messages->closeCursor();
	$req_membre_clavier->closeCursor();
	$req_clavier->closeCursor();
}
if($_GET['req']=='msg_salon_commun')
{
	$req_messages=$bdd->query('SELECT * FROM salon ORDER BY id_message DESC LIMIT 0, 15');
	while($messages=$req_messages->fetch())
	{
		$parle_moi=0;
		$req_auteur=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_auteur');
		$req_auteur->execute(array(
			'id_auteur' => $messages['id_auteur'],
			));
		$auteur=$req_auteur->fetch();
		$messages['contenu_message']=str_replace('<', '&lt;', $messages['contenu_message']);
		$messages['contenu_message']=str_replace('>', '&gt;', $messages['contenu_message']);
		$messages['date_message']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $messages['date_message']);
		if(preg_match('#@' . $recherche['pseudo'] . '#isU', $messages['contenu_message']))
		{
			$parle_moi=1;
		}
		if(!$auteur['pseudo'])
		{
			echo '<message parlemoi="' . $parle_moi . '" id_auteur="' . $_SESSION['id_membre'] . '" contenu="' . htmlspecialchars(emoticons(linkeur(citeur_mm(hashtageur($messages['contenu_message']))))) . '" date="' . $messages['date_message'] . '" pseudo="Ancien Membre"/>';
		}
		else
		{
			echo '<message parlemoi="' . $parle_moi . '" id_auteur="' . $messages['id_auteur'] . '" contenu="' . htmlspecialchars(emoticons(linkeur(citeur_mm(hashtageur($messages['contenu_message']))))) . '" date="' . $messages['date_message'] . '" pseudo="' . $auteur['pseudo'] . '"/>';
		}
		$req_auteur->closeCursor();
	}
	$req_messages->closeCursor();
}
?>
</corp>
