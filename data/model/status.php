<?php
/* 
status.php contient toutes les fonctions essentielles à la gestion des statuts tel que la suppression, la création etc ...
*/
include('notifications.php');
function create_status($content, $id, $image, $stat_img, $bdd)
{
	if(ismyFriend($id, $bdd) || $id==$_SESSION['id_membre'] && strlen($content)>0 || admin_check($bdd))
	{
		if($stat_img=='1')
		{
			if($image['size']>2000000)
			{
			}
			else
			{
				if($image['error']==0)
				{
					$inf_photo=pathinfo($image['name']);
					$photo_ext=$inf_photo['extension'];
					$photo_ext_auto=array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
					if(in_array($photo_ext, $photo_ext_auto))
					{
						$nmb_al=mt_rand(0, 500);
						$urlimg='p/statutp/' . 'p' . date('Y') . '' . date('m') . '' . date('d') . '' . date('H') . '' . date('i') . '' . date('s') . '' . $nmb_al . 'x.' . $inf_photo['extension'];
						$urlmini='p/statutp/' . 'p' . date('Y') . '' . date('m') . '' . date('d') . '' . date('H') . '' . date('i') . '' . date('s') . '' . $nmb_al . 'x_mini.' . $inf_photo['extension'];
						move_uploaded_file($image['tmp_name'], $urlimg);
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
						$content.='|~' . $urlimg . '~|';
					}
				}
			}
		}
		$regex_hashtag='A-Z0-9éèàêëâä\-_à€';
		$req_insert_statut=$bdd->prepare('INSERT INTO statuts (membre_statut, ecrivain_statut, aime_statut, aime_pas_statut, contenu_statut) VALUES(:membre_statut, :ecrivain_statut, :aime, :aime_pas, :contenu_statut)');
		$req_insert_statut->execute(array(
			'membre_statut' => $id,
			'aime_pas' => 'a:0:{}',
			'aime' => 'a:0:{}',
			'ecrivain_statut' => $_SESSION['id_membre'],
			'contenu_statut' => $content,
			));
		if(preg_match('#@([' . $regex_hashtag . ']+)#i', $content))
		{
			$result=preg_replace('#@([' . $regex_hashtag . ']+)#i', 'ø$0ø', $content);
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
						creer_notif($mm_exi['id_membre'], 'index.php?id=' . $id, $info_user['pseudo'] . ' vient de vous citer !', $info_user['avatar']);
					}
				}
			}
		}
		if($id!=$_SESSION['id_membre'])
		{
			creer_notif($id, 'index.php?id=' . $id, $info_user['pseudo'] . ' vient de publier sur votre fil d\'actu !', $info_user['avatar'], $bdd);
		}
		for($i=0;$i<count($liste_suiveur);$i++)
		{
			if($liste_suiveur[$i]!='')
			{
				if($id==$_SESSION['id_membre'])
				{
					creer_notif($liste_suiveur[$i], 'index.php?id=' . $id, $info_user['pseudo'] . ' vient de publier un statut !', $info_user['avatar'], $bdd);
				}
			}
		}
		return true;
	}
	else
	{
		return false;
	}
}
function delete_status($id, $bdd)
{
	$req_status=$bdd->prepare('SELECT ecrivain_statut FROM statuts WHERE id_statut = :id');
	$req_status->execute(array(
		'id' => $id,
		));
	$result=$req_status->fetch();
	if($result['ecrivain_statut']==$_SESSION['id_membre'] || admin_check($bdd))
	{
		$req=$bdd->prepare('DELETE FROM statuts WHERE id_statut = :id');
		$req->execute(array(
			'id' => $id,
		));
		$req2=$bdd->prepare('DELETE FROM notifications WHERE lien REGEXP :regex');
		$req2->execute(array(
			'regex' => '#post' . $id,
		));
		return true;
	}
	else
	{
		return false;
	}
}
function like_status($id, $bdd)
{
	$req_status=$bdd->prepare('SELECT aime_statut, ecrivain_statut, membre_statut FROM statuts WHERE id_statut = :id');
	$req_status->execute(array(
		'id' => $id,
		));
	$result=$req_status->fetch();
	$likes=unserialize($result['aime_statut']);
	if(in_array($_SESSION['id_membre'], $likes))
	{
		$key=array_search($_SESSION['id_membre'], $likes);
		unset($likes[$key]);
		$new_likes=serialize($likes);
		$return_data=1;
	}
	else
	{
		$likes[]=$_SESSION['id_membre'];
		$new_likes=serialize($likes);
		$return_data=0;
	}
	$maj=$bdd->prepare('UPDATE statuts SET aime_statut = :likes WHERE id_statut = :id');
	$maj->execute(array(
		'likes' => $new_likes,
		'id' => $id,
		));
	if($result['ecrivain_statut']!=$_SESSION['id_membre'])
	{
		$req=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id');
		$req->execute(array(
			'id' => $_SESSION['id_membre'],
			));
		$res=$req->fetch();
		creer_notif($result['ecrivain_statut'], 'index.php?page=profile&id=' . $result['membre_statut'] . '#post' . $id, $res['pseudo'] . ' aime votre statut', $bdd);
	}
	return $return_data;
}
function unlike_status($id, $bdd)
{
	$req_status=$bdd->prepare('SELECT aime_pas_statut FROM statuts WHERE id_statut = :id');
	$req_status->execute(array(
		'id' => $id,
		));
	$result=$req_status->fetch();
	$notlikes=unserialize($result['aime_pas_statut']);
	if(in_array($_SESSION['id_membre'], $notlikes))
	{
		$key=array_search($_SESSION['id_membre'], $notlikes);
		unset($notlikes[$key]);
		$new_notlikes=serialize($notlikes);
		$return_data=1;
	}
	else
	{
		$notlikes[]=$_SESSION['id_membre'];
		$new_notlikes=serialize($notlikes);
		$return_data=0;
	}
	$maj=$bdd->prepare('UPDATE statuts SET aime_pas_statut = :notlikes WHERE id_statut = :id');
	$maj->execute(array(
		'notlikes' => $new_notlikes,
		'id' => $id,
		));
	if($result['ecrivain_statut']!=$_SESSION['id_membre'])
	{
		$req=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id');
		$req->execute(array(
			'id' => $_SESSION['id_membre'],
			));
		$res=$req->fetch();
		creer_notif($result['ecrivain_statut'], 'index.php?page=profile&id=' . $result['membre_statut'] . '#post' . $id, $res['pseudo'] . ' n\'aime pas votre statut', $bdd);
	}
	return $return_data;
}
// Récupere les informations sur un status tel que le nombre de commentaires, j'aime, j'aime pas ...
function getStatusInfo($id, $bdd)
{
	$req_status=$bdd->prepare('SELECT * FROM statuts WHERE id_statut = :id');
	$req_status->execute(array(
		'id' => $id,
		));
	$result=$req_status->fetchAll();
	return $result;
}
function create_comment($id, $comment, $bdd)
{
	
}
function delete_comment($id, $bdd)
{
	
}
function getUserStatus($id, $limit=15, $bdd)
{
	$req_status=$bdd->prepare('SELECT * FROM statuts WHERE membre_statut = :membre ORDER BY id_statut DESC LIMIT 0, :limite');
	$req_status->bindValue('membre', $id, PDO::PARAM_INT);
	$req_status->bindValue('limite', $limit, PDO::PARAM_INT);
	$req_status->execute();
	$result=$req_status->fetchAll();
	return $result;
}
?>
