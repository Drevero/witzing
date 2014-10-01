<?php
include_once('data/model/members.php');
if(isset($_POST['mail']) && isset($_POST['passe']))
{
	if(connect($_POST['mail'], $_POST['passe'], $bdd))
	{
		header('Location: index.php?page=profile&id=' . $_SESSION['id_membre']);
	}
	else
	{
		header('Location: index.php?i');
	}
}
if(isset($_POST['pseudo_inscr']) && isset($_POST['mail_inscr']) && isset($_POST['passe_inscr']))
{
	if(create_account($_POST['mail_inscr'], $_POST['pseudo_inscr'], $_POST['passe_inscr'], $bdd))
	{
		header('Location: accountcreee.php');
	}
	else
	{
		header('Location: index.php?erreur');
	}
}
include_once('data/view/index.php');
?>
