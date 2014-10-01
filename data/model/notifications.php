<?php
/* 
notifications.php contient toutes les fonctions qui consiste aux traitement des notifications du membre 
*/
function creer_notif($id_membre, $lien, $contenu, $bdd)
{
	$req_insert_notif_statut=$bdd->prepare('INSERT INTO notifications (membre_notif, contenu, lien, emetteur_notif, lu) VALUES(:membre_notif, :contenu, :lien, :emetteur_notif, 0)');
	$req_insert_notif_statut->execute(array(
		'membre_notif' => $id_membre,
		'contenu' => $contenu,
		'lien' => $lien,
		'emetteur_notif' => $_SESSION['id_membre'],
		));
}
?>
