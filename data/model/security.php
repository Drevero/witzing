<?php
/* 
security.php contient toutes les fonctions essentielles aux vérifications de sécurité ...
*/
function connected($bdd)
{
	
}
function admin_check($bdd)
{
	$req=$bdd->prepare('SELECT admin FROM membres WHERE id_membre = :id');
	$req->execute(array(
		'id' => $_SESSION['id_membre'],
		));
	$result=$req->fetch();
	if($result['admin']=='1')
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>
