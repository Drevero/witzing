<?php
session_start();
include_once('data/core/bdd.php');
if(isset($_SESSION['id_membre']) && isset($_GET['page']))
{
	$array_page=['profile', 'ajax'];
	if(in_array($_GET['page'], $array_page))
	{
		include_once('data/core/' . $_GET['page'] . '.php');
	}
	else
	{
		header('Location: index.php?page=profile&id=' . $_SESSION['id_membre']);
	}
}
else
{
	if(!isset($_SESSION['id_membre']))
	{
		if(isset($_GET['page']))
		{
			header('Location: index.php');
		}
		include_once('data/core/index.php');
	}
	else
	{
		if(isset($_GET['dec']))
		{
			include_once('data/model/members.php');
			deconnect();
			header('Location: index.php');
		}
		else
		{
			header('Location: index.php?page=profile&id=' . $_SESSION['id_membre']);
		}
	}
}
?>
