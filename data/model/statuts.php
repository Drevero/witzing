<?php
/* 
statuts.php contient toutes les fonctions essentielles à la gestion des statuts tel que la suppression, la création etc ...
*/
function create_status($content, $id, $bdd)
{

}
function delete_status($id, $bdd)
{
	
}
function like_status($id, $bdd)
{
	
}
function unlike_status($id, $bdd)
{
	
}
// Récupere les informations sur un status tel que le nombre de commentaires, j'aime, j'aime pas ...
function getStatusInfo($id, $bdd)
{
	
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
	$result=$req_status->fetch();
	return $result;
}
?>
