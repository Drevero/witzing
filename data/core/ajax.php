<?php
include_once('data/model/status.php');
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
if(isset($_GET['id_supr_post']))
{
	$_GET['id_supr_post']=(int) $_GET['id_supr_post'];
	delete_status($_GET['id_supr_post'], $bdd);
}
include_once('data/view/ajax.php');
?>
