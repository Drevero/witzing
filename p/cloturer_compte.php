<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
if(isset($_GET['oui']))
{
	unlink($recherche['avatar']);
	for($i=0;$i<count($liste_suiveur);$i++)
	{
		if($liste_suiveur[$i]!='')
		{
			creer_notif($liste_suiveur[$i], 'index.php?id=' . $liste_suiveur[$i], $recherche['pseudo'] . ' vient de cloturer son compte', '../data/style/logo.png');
		}
	}
	for($i=0;$i<count($liste_amis);$i++)
	{
		if($liste_amis[$i]!='' && !(in_array($liste_amis[$i], $liste_suiveur)))
		{
			creer_notif($liste_amis[$i], 'index.php?id=' . $liste_amis[$i], $recherche['pseudo'] . ' vient de cloturer son compte', '../data/style/logo.png');
		}
		if($liste_amis[$i]!='')
		{
			$req_amis=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
			$req_amis->execute(array(
				'id_membre' => $liste_amis[$i],
				));
			$amis=$req_amis->fetch();
			$supr_attente=$amis['attente_amis'];
			$supr_attente=str_replace('*' . $_SESSION['id_membre'] . '*', '', $supr_attente);
			$maj_attentes=$bdd->prepare('UPDATE membres SET attente_amis = :supr WHERE id_membre = :id_membre');
			$maj_attentes->execute(array(
				'id_membre' => $liste_amis[$i],
				'supr' => $supr_attente,
				));
			$supr_amis=$amis['amis'];
			$supr_amis=str_replace('*' . $_SESSION['id_membre'] . '*', '', $supr_amis);
			$maj_amis=$bdd->prepare('UPDATE membres SET amis = :supr WHERE id_membre = :id_membre');
			$maj_amis->execute(array(
				'id_membre' => $liste_amis[$i],
				'supr' => $supr_amis,
				));
			$req_amis->closeCursor();
		}
	}
	$req_abonnements=$bdd->prepare('SELECT * FROM membres WHERE suivis REGEXP :id_membre');
	$req_abonnements->execute(array(
		'id_membre' => '\*' . $_SESSION['id_membre'] . '\*',
		));
	while($abonnements=$req_abonnements->fetch())
	{
		$supr_abon=$abonnements['suivis'];
		$supr_abon=str_replace('*' . $_SESSION['id_membre'] . '*', '', $supr_abon);
		$maj_abon=$bdd->prepare('UPDATE membres SET suivis = :suivis WHERE id_membre = :id_membre');
		$maj_abon->execute(array(
			'id_membre' => $abonnements['id_membre'],
			'suivis' => $supr_abon,
			));
	}
	$req_abonnements->closeCursor();
	$req_aimes=$bdd->prepare('SELECT * FROM membres WHERE aime REGEXP :id_membre');
	$req_aimes->execute(array(
		'id_membre' => '\*' . $_SESSION['id_membre'] . '\*',
		));
	while($aimes=$req_aimes->fetch())
	{
		$supr_aime=$aimes['aime'];
		$supr_aime=str_replace('*' . $_SESSION['id_membre'] . '*', '', $supr_aime);
		$maj_aime=$bdd->prepare('UPDATE membres SET aime = :aime WHERE id_membre = :id_membre');
		$maj_aime->execute(array(
			'id_membre' => $aimes['id_membre'],
			'aime' => $supr_aime,
			));
	}
	$req_aimes->closeCursor();
	$req_supr_statut=$bdd->prepare('DELETE FROM statuts WHERE membre_statut = :id_membre');
	$req_supr_statut->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	$req_supr_statut_autre=$bdd->prepare('DELETE FROM statuts WHERE ecrivain_statut = :id_membre');
	$req_supr_statut_autre->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	$req_supr_aime_statut=$bdd->prepare('SELECT * FROM statuts WHERE aime_statut REGEXP :id_membre');
	$req_supr_aime_statut->execute(array(
		'id_membre' => '\*' . $_SESSION['id_membre'] . '\*',
		));
	while($aime_statut=$req_supr_aime_statut->fetch())
	{
		$supr_aime_statut=$aime_statut['aime_statut'];
		$supr_aime_statut=str_replace('*' . $_SESSION['id_membre'] . '*', '', $supr_aime_statut);
		$maj_aime_statut=$bdd->prepare('UPDATE statuts SET aime_statut = :aime_statut WHERE id_statut = :id_statut');
		$maj_aime_statut->execute(array(
			'id_statut' => $aime_statut['id_statut'],
			'aime_statut' => $supr_aime_statut,
			));
	}
	$req_supr_aime_statut->closeCursor();
	$req_supr_aime_pas_statut=$bdd->prepare('SELECT * FROM statuts WHERE aime_statut REGEXP :id_membre');
	$req_supr_aime_pas_statut->execute(array(
		'id_membre' => '\*' . $_SESSION['id_membre'] . '\*',
		));
	while($aime_pas_statut=$req_supr_aime_pas_statut->fetch())
	{
		$supr_aime_pas_statut=$aime_pas_statut['aime_pas_statut'];
		$supr_aime_pas_statut=str_replace('*' . $_SESSION['id_membre'] . '*', '', $supr_aime_pas_statut);
		$maj_aime_pas_statut=$bdd->prepare('UPDATE statuts SET aime_pas_statut = :aime_pas_statut WHERE id_statut = :id_statut');
		$maj_aime_pas_statut->execute(array(
			'id_statut' => $aime_pas_statut['id_statut'],
			'aime_pas_statut' => $supr_aime_pas_statut,
			));
	}
	$req_supr_aime_pas_statut->closeCursor();
	$req_membre_supr=$bdd->prepare('DELETE FROM membres WHERE id_membre = :id_membre');
	$req_membre_supr->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	$req_supr_comment=$bdd->prepare('DELETE FROM comment_statuts WHERE id_auteur = :id_membre');
	$req_supr_comment->execute(array(
		'id_membre' => $_SESSION['id_membre'],
		));
	session_destroy();
	header('Location: ../index.php');
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Cloturer mon compte</title>
<link rel="stylesheet" href="../data/style/style.css"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
	<p id="parametre_compte_texte">Êtes-vous vraiment sûr(e) de vouloir clôturer votre compte ?</p>
	<div id="conteneur_cloturation">
		<p id="infos_cloturation">L'action de cloturer un compte est définitive et irréversible. Lors de la cloturation vous perdrez tout vos commentaires/statuts/abonnés/amis etc ...<br /><br />Si la cloturation de votre compte est dûe à un manque de maturité du projet Witzing ou à une déception relative à celui-ci, vous pouvez bien sûr me faire part de vos commentaires à cette adresse email : drevero@drevero.zz.mu.<br /><br />Pour terminer, une notification sera envoyée à tous vos abonnés/amis de votre cloturation.<br /><br />Aurevoir <?php echo htmlspecialchars($recherche['pseudo']); ?>.</p>
		<a href="cloturer_compte.php?oui" title="Cloturer le compte"><input type="button" value="Oui je suis sûr(e)" id="cloturer_compte_confirm"/></a>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.js"></script>
</body>
</html>
