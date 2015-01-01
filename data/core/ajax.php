<?php
include_once('data/model/status.php');
include_once('data/model/members.php');
include_once('data/model/tools.php');
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
if(isset($_GET['show_comments']))
{
	$_GET['show_comments']=(int) $_GET['show_comments'];
	$comments=getStatusComments($_GET['show_comments'], $bdd);
	for($i=0;$i<count($comments);$i++)
	{
		$member_comment=getUserInfo($comments[$i]['id_auteur'], $bdd);
		$isme=(($comments[$i]['id_auteur']==$_SESSION['id_membre'])) ? $isme=1 : $isme=0;
		$comments[$i]['date_comment']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $comments[$i]['date_comment']);
		$return_data.='<comment me="' . $isme . '" id="' . $comments[$i]['id_comment'] . '" author_id="' . $comments[$i]['id_auteur'] . '" author="' . htmlspecialchars($member_comment['pseudo']) . '" date="' . $comments[$i]['date_comment'] . '" text="' . htmlspecialchars(markdown(linkeur(hashtageur(citeur_mm($comments[$i]['comment']))))) . '" avatar="' . htmlspecialchars($member_comment['avatar']) . '"/>';
	}
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
