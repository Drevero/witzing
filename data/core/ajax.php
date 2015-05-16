<?php
include_once('data/model/status.php');
include_once('data/model/members.php');
include_once('data/model/tools.php');
include_once('data/model/notifications.php');
if(isset($_GET['like_stats']))
{
	$info=getStatusInfo($_GET['like_stats'], $bdd);
	$likes=count(unserialize($info[0]['aime_statut']));
	$return_data='<like me="' . like_status($_GET['like_stats'], $bdd) . '" total="' . $likes . '"/>';
}
if(isset($_GET['notlike_stats']))
{
	$info=getStatusInfo($_GET['notlike_stats'], $bdd);
	$unlikes=count(unserialize($info[0]['aime_pas_statut']));
	$return_data='<unlike me="' . unlike_status($_GET['notlike_stats'], $bdd) . '" total="' . $unlikes . '"/>';
}
if(isset($_GET['delete_comment']))
{
	delete_comment($_GET['delete_comment'], $bdd);
}
if(isset($_GET['id_supr_post']))
{
	$_GET['id_supr_post']=(int) $_GET['id_supr_post'];
	delete_status($_GET['id_supr_post'], $bdd);
}
if(isset($_GET['read_all']))
{
	$update=$bdd->prepare('UPDATE notifications SET lu = 1 WHERE membre_notif = :id_membre');
	$update->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
}
if(isset($_GET['show_comments']))
{
	$_GET['show_comments']=(int) $_GET['show_comments'];
	$comments=getStatusComments($_GET['show_comments'], $bdd);
	for($i=0;$i<count($comments);$i++)
	{
		$member_comment=getUserInfo($comments[$i]['id_auteur'], $bdd);
		$isme=(($comments[$i]['id_auteur']==$_SESSION['id_membre'])) ? $isme=1 : $isme=0;
		$comments[$i]['date_comment']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $comments[$i]['date_comment']);
		$return_data.='<comment me="' . $isme . '" id="' . $comments[$i]['id_comment'] . '" author_id="' . $comments[$i]['id_auteur'] . '" author="' . coupeur(htmlspecialchars($member_comment['pseudo']), 6) . '" date="' . $comments[$i]['date_comment'] . '" text="' . htmlspecialchars(markdown(linkeur(hashtageur(citeur_mm($comments[$i]['comment']))))) . '" avatar="' . htmlspecialchars($member_comment['avatar']) . '"/>';
	}
}
if(isset($_GET['follow']))
{
	$req=getUserInfo($_GET['follow'], $bdd);
	$followers=unserialize($req['suivis']);
	$nmb_followers=count($followers);
	if($_GET['follow']!=$_SESSION['id_membre'])
	{
		$return_data=follow_member($_GET['follow'], $bdd);
		if($return_code)
		{
			$return_data='<follow stat="1" nmb="' . $nmb_followers . '"/>';
		}
		else
		{
			$nmb_followers-=1;
			$return_data='<follow stat="0" nmb="' . $nmb_followers . '"/>';
		}
	}
}
if(isset($_GET['reject_member']))
{
	$req=getUserInfo($_SESSION['id_membre'], $bdd);
	$friends_wait=unserialize($req['attente_amis']);
	if(in_array($_GET['reject_member'], $friends_wait))
	{
		$key_id=array_search($_GET['reject_member'], $friends_wait);
		unset($friends_wait[$key_id]);
		$friends_wait=array_filter($friends_wait);
		$array_moded=serialize($friends_wait);
		$final=$bdd->prepare('UPDATE membres SET attente_amis = :array_moded WHERE id_membre = :id');
		$final->execute(array(
			'array_moded' => $array_moded,
			'id' => $_SESSION['id_membre'],
			));
	}
}
if(isset($_GET['accept_friend']))
{
	$req=getUserInfo($_SESSION['id_membre'], $bdd);
	$friends_wait=unserialize($req['attente_amis']);
	$friends_list=unserialize($req['amis']);
	$req2=getUserInfo($_GET['accept_friend'], $bdd);
	$friends_list2=unserialize($req2['amis']);
	if(in_array($_GET['accept_friend'], $friends_wait))
	{
		$key_id=array_search($_GET['accept_friend'], $friends_wait);
		unset($friends_wait[$key_id]);
		$friends_wait=array_filter($friends_wait);
		$friends_list[]=$_GET['accept_friend'];
		$array_moded=serialize($friends_wait);
		$array2_moded=serialize($friends_list);
		$final=$bdd->prepare('UPDATE membres SET attente_amis = :array_moded, amis = :array2_moded WHERE id_membre = :id');
		$final->execute(array(
			'array_moded' => $array_moded,
			'array2_moded' => $array2_moded,
			'id' => $_SESSION['id_membre'],
			));
		$final->closeCursor();
		$friends_list2[]=$_SESSION['id_membre'];
		$array3_moded=serialize($friends_list2);
		$final=$bdd->prepare('UPDATE membres SET amis = :array3_moded WHERE id_membre = :id');
		$final->execute(array(
			'array3_moded' => $array3_moded,
			'id' => $_GET['accept_friend'],
			));
	}
}
if(isset($_GET['mynotifications']))
{
	$req=$bdd->prepare('SELECT * FROM notifications WHERE membre_notif = :id ORDER BY id_notif DESC LIMIT 0, 12');
	$req->execute(array(
		'id' => $_SESSION['id_membre'],
		));
	$alert=false;
	while($result=$req->fetch())
	{
		$member=getUserInfo($result['emetteur_notif'], $bdd);
		if($result['lu']==0)
		{
			$alert=true;
		}
		$return_data.='<notif avatar="' . $member['avatar'] . '" friendask="false" name="' . htmlspecialchars($member['pseudo']) . '" content="' . htmlspecialchars($result['contenu']) . '" link="' . htmlspecialchars($result['lien']) . '" read="' . $result['lu'] . '"/>';
	}
	$req->closeCursor();
	$req=$bdd->prepare('SELECT attente_amis FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $_SESSION['id_membre'],
		));
	$result=$req->fetch();
	$list_friends_ask=unserialize($result['attente_amis']);
	for($i=0;$i<count($list_friends_ask);$i++)
	{
		$member=getUserInfo($list_friends_ask[$i], $bdd);
		$return_data.='<notif avatar="' . $member['avatar'] . '" friendask="true" name="' . htmlspecialchars($member['pseudo']) . '" link="' . htmlspecialchars('index.php?page=profile&id=' . $member['id_membre']) . '" id="' . $member['id_membre'] . '"/>';
		$alert=true;
	}
	if($alert)
	{
		$return_data.='<alert stat="1"/>';
	}
	else
	{
		$return_data.='<alert stat="0"/>';
	}
}
if(isset($_GET['notif_and_msg']))
{
	$req=$bdd->prepare('SELECT * FROM notifications WHERE membre_notif = :id ORDER BY id_notif DESC');
	$req->execute(array(
		'id' => $_SESSION['id_membre'],
		));
	$alert=false;
	while($result=$req->fetch())
	{
		if($result['lu']==0)
		{
			$alert=true;
		}
	}
	$req->closeCursor();
	$req=$bdd->prepare('SELECT attente_amis FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $_SESSION['id_membre'],
		));
	$result=$req->fetch();
	$list_friends_ask=unserialize($result['attente_amis']);
	if(count($list_friends_ask)>=1)
	{
		$alert=true;
	}
	if($alert)
	{
		$return_data.='<alert stat="1"/>';
	}
	else
	{
		$return_data.='<alert stat="0"/>';
	}
}
if(isset($_GET['friend']))
{
	$_GET['friend']=(int) $_GET['friend'];
	$friend=getUserInfo($_GET['friend'], $bdd);
	$list_friends=unserialize($friend['amis']);
	$waiting_for=unserialize($friend['attente_amis']);
	$me_info=getUserInfo($_SESSION['id_membre'], $bdd);
	$list_friends_me=unserialize($me_info['amis']);
	$action=true;
	if(in_array($_SESSION['id_membre'], $list_friends))
	{
		if($action)
		{
			$pos_me=array_search($_SESSION['id_membre'], $list_friends);
			unset($list_friends[$pos_me]);
			$array_friend=serialize($list_friends);
			$update=$bdd->prepare('UPDATE membres SET amis = :list_friends WHERE id_membre = :id_membre');
			$update->execute(array(
				'list_friends' => $array_friend,
				'id_membre' => $_GET['friend'],
			));
			$update->closeCursor();
			$pos_me2=array_search($_GET['friend'], $list_friends_me);
			unset($list_friends_me[$pos_me2]);
			$array_friend2=serialize($list_friends_me);
			$update=$bdd->prepare('UPDATE membres SET amis = :list_friends WHERE id_membre = :id_membre');
			$update->execute(array(
				'list_friends' => $array_friend,
				'id_membre' => $_SESSION['id_membre'],
			));
			$stat='no';
			$action=false;
		}
	}
	if(in_array($_SESSION['id_membre'], $waiting_for))
	{
		if($action)
		{
			$pos_me=array_search($_SESSION['id_membre'], $waiting_for);
			unset($waiting_for[$pos_me]);
			$array_friend=serialize($waiting_for);
			$update=$bdd->prepare('UPDATE membres SET attente_amis = :waiting_for WHERE id_membre = :id_membre');
			$update->execute(array(
				'waiting_for' => $array_friend,
				'id_membre' => $_GET['friend'],
			));
			$stat='no';
			$action=false;
		}
	}
	if(!in_array($_SESSION['id_membre'], $waiting_for) && !in_array($_SESSION['id_membre'], $list_friends))
	{
		if($action)
		{
			$waiting_for[]=$_SESSION['id_membre'];
			$array_friend=serialize($waiting_for);
			$update=$bdd->prepare('UPDATE membres SET attente_amis = :waiting_for WHERE id_membre = :id_membre');
			$update->execute(array(
				'waiting_for' => $array_friend,
				'id_membre' => $_GET['friend'],
			));
			$stat='waiting';
		}
	}
	$return_data.='<friend stat="' . $stat . '"/>';
}
if(isset($_POST['comment']) && isset($_POST['id_post']))
{
	if(strlen($_POST['comment'])<=200)
	{
		create_comment(htmlspecialchars($_POST['comment']), $_POST['id_post'], $bdd);
	}
}
include_once('data/view/ajax.php');
?>
