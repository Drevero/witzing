<?php
/* 
members.php contient toutes les fonctions essentielles à la gestion d'un compte membre tel que la suppression, la création, la modification etc ...
*/
function create_account($mail, $username, $password, $bdd)
{
	if(strlen($username)>3 && strlen($password)>3  && !preg_match('# #isU', $username) && !preg_match('#>#isU', $username) && preg_match('#(.+)@(.+)\.(.+)#', $mail))
	{
		$req_membre=$bdd->prepare('SELECT pseudo FROM membres WHERE pseudo = :pseudo');
		$req_membre->execute(array(
			'pseudo' => $username,
			));
		$membre=$req_membre->fetch();
		$req_mail=$bdd->prepare('SELECT mail FROM membres WHERE mail = :mail');
		$req_mail->execute(array(
			'mail' => $mail,
			));
		$mail2=$req_mail->fetch();
		if($membre || $mail2)
		{
			if($membre)
			{
				return false;
			}
			if($mail2)
			{
				return false;
			}
		}
		else
		{
			$req_insert_mm=$bdd->prepare('INSERT INTO membres (pseudo, passe, mail, avatar, date_inscription, badges, amis, suivis, aime, attente_amis) VALUES(:pseudo, :passe, :mail, :avatar, NOW(), :badges, :amis, :suivis, :aime, :attente_amis)');
			$req_insert_mm->execute(array(
				'pseudo' => $username,
				'passe' => $password,
				'mail' => $mail,
				'avatar' => 'data/style/portrait_defaut.png',
				'badges' => 'a:1:{i:0;s:1:"3";}',
				'amis' => 'a:0:{}',
				'suivis' => 'a:0:{}',
				'aime' => 'a:0:{}',
				'attente_amis' => 'a:1:{i:0;s:1:"1";}',
				));
			$recup_id=$bdd->prepare('SELECT id_membre FROM membres WHERE pseudo = :membre');
			$recup_id->execute(array(
				'membre' => $username,
				));
			$recup=$recup_id->fetch();
			$_SESSION['id_membre']=$recup['id_membre'];
			$req_insert_notif=$bdd->prepare('INSERT INTO notifications (membre_notif, contenu, lien, avatar, lu) VALUES(:membre_notif, :contenu, :lien, :avatar, 0)');
			$req_insert_notif->execute(array(
				'membre_notif' => $recup['id_membre'],
				'lien' => 'index.php',
				'contenu' => 'Vous avez reçus votre premier badge !',
				'avatar' => '../data/style/logo.png',
				));
			return true;
		}
	}
}
function mod_account($mail, $username, $password, $avatar=false, $bdd)
{
	
}
function delete_account($id, $bdd)
{
	
}
function getUserInfo($id, $bdd)
{
	$req=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $id,
		));
	$result=$req->fetch();
	if($result)
	{
		return $result;
	}
}
function im_following($id, $bdd)
{
	$req=$bdd->prepare('SELECT suivis FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $id,
		));
	$result=$req->fetch();
	$following=unserialize($result['suivis']);
	if(in_array($_SESSION['id_membre'], $following))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function fetch_all_likes($id, $bdd)
{
	$first_req=$bdd->prepare('SELECT * FROM statuts WHERE ecrivain_statut = :id');
	$first_req->execute(array(
		'id' => $id,
		));
	$nmb_likes=0;
	while($result=$first_req->fetch())
	{
		$status_likes=$result['aime_statut'];
		$nmb_likes+=count(unserialize($status_likes));
	}
	return $nmb_likes;
}
function follow_member($id, $bdd)
{
	$req=$bdd->prepare('SELECT suivis FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $id,
		));
	$result=$req->fetch();
	$array_follow=unserialize($result['suivis']);
	$action=true;
	if(in_array($_SESSION['id_membre'], $array_follow))
	{
		$key_id=array_search($id, $array_follow);
		unset($array_follow[$key_id]);
		$array_follow=array_filter($array_follow);
		$return_code=false;
		$action=false;
	}
	elseif($action)
	{
		$array_follow[]=$_SESSION['id_membre'];
		$return_code=true;
	}
	$array_moded=serialize($array_follow);
	$final=$bdd->prepare('UPDATE membres SET suivis = :array_moded WHERE id_membre = :id');
	$final->execute(array(
		'array_moded' => $array_moded,
		'id' => $id,
		));
	$info=getUserInfo($_SESSION['id_membre'], $bdd);
	creer_notif($id, 'index.php?page=profile&id=' . $_SESSION['id_membre'], $info['pseudo'] . ' s\'est abonné à vous', $bdd);
	return $return_code;
}
function getUserMps($id, $bdd)
{
	$req=$bdd->prepare('SELECT COUNT(*) AS nmb_msg FROM messages_perso WHERE id_auteur = :id');
	$req->execute(array(
		'id' => $id,
		));
	$result=$req->fetch();
	if($result)
	{
		return $result['nmb_msg'];
	}
}
function online($id, $bdd)
{
	$req=$bdd->prepare('SELECT derniere_activite FROM membres WHERE id_membre = :id_membre');
	$req->execute(array(
		'id_membre' => $id,
		));
	$mm_co=$req->fetch();
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
function ismyFriend($id, $bdd)
{
	$info=getUserInfo($id, $bdd);
	$info_friend=unserialize($info['amis']);
	if(in_array($_SESSION['id_membre'], $info_friend))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function member_exist($id, $bdd)
{
	$req=$bdd->prepare('SELECT id_membre FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $id,
		));
	$result=$req->fetch();
	if($result)
	{
		return true;
	}
}
function member_name($id, $bdd)
{
	$req=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $id,
		));
	$result=$req->fetch();
	if($result)
	{
		return $result['pseudo'];
	}
}
function connect($mail, $password, $bdd)
{
	$req_con=$bdd->prepare('SELECT * FROM membres WHERE mail = :mail and passe = :passe');
	$req_con->execute(array(
		'mail' => $mail,
		'passe' => $password,
		));
	$result=$req_con->fetch();
	if($result)
	{
		$_SESSION['id_membre']=$result['id_membre'];
		$req_con=$bdd->prepare('UPDATE membres SET dernier_activite = NOW(), derniere_con = NOW() WHERE mail = :mail AND passe = :passe');
		$req_con->execute(array(
			'mail' => $mail,
			'passe' => $password,
			));
		$req_con->closeCursor();
		return true;
	}
	else
	{
		return false;
	}
}
function deconnect()
{
	session_destroy();
}
?>
