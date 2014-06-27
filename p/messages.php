<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
session_start();
if(!isset($_GET['id']) && $_GET['id']==$_SESSION['id_membre'])
{
	header('Location: ../index.php');
}
include('../data/bdd.php');
include('../data/standard.php');
if(!in_array($_GET['id'], $liste_amis))
{
	header('Location: index.php?id=' . $_SESSION['id_membre']);
}
$req_info_membre=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
$req_info_membre->execute(array(
	'id' => $_GET['id'],
	));
$info_membre=$req_info_membre->fetch();
$identifiant_salon='';
if($_SESSION['id_membre']>$info_membre['id_membre'])
{
	$identifiant_salon='*' . $_SESSION['id_membre'] . '*' . $info_membre['id_membre'] . '*';
}
else
{
	$identifiant_salon='*' . $info_membre['id_membre'] . '*' . $_SESSION['id_membre'] . '*';
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Conversation avec <?php echo htmlspecialchars($info_membre['pseudo']); ?></title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
<?php
if(!(isset($_GET['archive'])))
{
?>
<p id="pseudo_converse"><?php echo htmlspecialchars($info_membre['pseudo']); ?><img <?php if(membreconnecte($bdd, $info_membre['id_membre'])) { echo 'src="../data/style/led1.png" title="Connecté"'; } else { echo 'src="../data/style/led0.png" title="Déconnecté"'; } ?> id="con_message"/></p>
<div id="conteneur_messages">
<?php
$req_lus=$bdd->prepare('UPDATE messages_perso SET lu = 1 WHERE lu = 0 AND salon = :salon AND id_auteur != :id_membre');
$req_lus->execute(array(
	'salon' => $identifiant_salon,
	'id_membre' => $_SESSION['id_membre'],
));
?>
</div>
<form name="message" id="message" action="" onsubmit="envois_mp('<?php echo $identifiant_salon; ?>', document.getElementById('cont_message').value);return false;">
	<p id="texte_infos_msg"></p>
	<input type="text" maxlength="500" onclick="msg_lu('<?php echo $identifiant_salon; ?>');" placeholder="Envoyer un message à <?php echo htmlspecialchars($info_membre['pseudo']); ?>" id="cont_message" onkeyup="verif_clavier('<?php echo $identifiant_salon; ?>');"/>
	<img src="../data/emoticons/smile2.png" onclick="boite_smiley('cont_message');" id="bt_ouvrir_smile"/>
</form>
<a href="messages.php?id=<?php echo $_GET['id']; ?>&amp;archive" id="archive_lien">Archive</a>
<script type="text/javascript" src="../data/witzing.php"></script>
<script>
message_salon('<?php echo $identifiant_salon; ?>');
</script>
<?php
}
else
{
if(isset($_GET['page']) && $_GET['page']>0)
{
	$limite_statut=(int) $_GET['page'];
}
else
{
	$limite_statut=4;
}
$req_nmb_msg=$bdd->prepare('SELECT COUNT(*) AS nmb_msg FROM messages_perso WHERE salon = :salon');
$req_nmb_msg->execute(array(
	'salon' => $identifiant_salon,
	));
$nmb_msg=$req_nmb_msg->fetch();
?>
<p id="pseudo_converse">Archive de conversation avec <?php echo htmlspecialchars($info_membre['pseudo']); ?> (<?php if($nmb_msg['nmb_msg']>100000) { echo '>100 000 messages O.o'; } else { echo $nmb_msg['nmb_msg']; ?> message<?php if($nmb_msg['nmb_msg']>1) { echo 's'; } } ?>)<img <?php if(membreconnecte($bdd, $info_membre['id_membre'])) { echo 'src="../data/style/led1.png" title="Connecté"'; } else { echo 'src="../data/style/led0.png" title="Déconnecté"'; } ?> id="con_message"/></p>
<div id="conteneur_messages">
<?php
$req_nmb_msg->closeCursor();
$req_messages=$bdd->prepare('SELECT * FROM messages_perso WHERE salon = :id_salon ORDER BY id_message DESC LIMIT 0, :limite');
$req_messages->bindValue('id_salon', $identifiant_salon, PDO::PARAM_INT);
$req_messages->bindValue('limite', $limite_statut, PDO::PARAM_INT);
$req_messages->execute();
while($messages=$req_messages->fetch())
{
	$req_auteur=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_auteur');
	$req_auteur->execute(array(
		'id_auteur' => $messages['id_auteur'],
		));
	$auteur=$req_auteur->fetch();
	$messages['date_message']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $messages['date_message']);
	if($messages['id_auteur']!=$_SESSION['id_membre'])
	{
	?>
	<div class="cadre_msg">
		<a href="index.php?id=<?php echo $messages['id_auteur']; ?>"><img src="<?php echo htmlspecialchars($auteur['avatar']); ?>" alt="avatar" class="avat_msg avat_msg_droite"/></a>
		<p class="date_texte date_texte_droite"><?php echo $messages['date_message']; ?></p>
		<p class="texte_msg texte_msg_droite"><?php echo emoticons(linkeur(citeur_mm(hashtageur(htmlspecialchars($messages['contenu']))))); ?></p>
	</div>
	<?php
	}
	else
	{
	?>
	<div class="cadre_msg">
		<a href="index.php?id=<?php echo $messages['id_auteur']; ?>"><img src="<?php echo htmlspecialchars($auteur['avatar']); ?>" alt="avatar" class="avat_msg"/></a>
		<p class="date_texte"><?php echo $messages['date_message']; ?></p>
		<p class="texte_msg"><?php echo emoticons(linkeur(citeur_mm(hashtageur(htmlspecialchars($messages['contenu']))))); ?></p>
	</div>
	<?php
	}
	$req_auteur->closeCursor();
}
$req_messages->closeCursor();
$limite_statut_plus=($limite_statut+4);
?><?php if($limite_statut<$nmb_msg['nmb_msg']) { ?><a href="messages.php?id=<?php echo $_GET['id']; ?>&amp;archive&amp;page=<?php echo $limite_statut_plus; ?>#afficher_plus_msg"><?php } ?><input type="button" <?php if($limite_statut>=$nmb_msg['nmb_msg']) { ?>class="pas_afficher"<?php } ?> value="Afficher plus" id="afficher_plus_msg"/><?php if($limite_statut<$nmb_msg['nmb_msg']) { ?></a><?php } ?><a href="messages.php?id=<?php echo $_GET['id']; ?>"><input type="button" value="Retour" id="bt_retour_discu"/></a>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
<?php
}
$req_info_membre->closeCursor();
?>
</div>
</body>
</html>
