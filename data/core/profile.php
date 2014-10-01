<?php
include_once('data/model/members.php');
include_once('data/model/security.php');
include_once('data/model/status.php');
include_once('data/model/tools.php');
$info_user=getUserInfo($_GET['id'], $bdd);
$badges_me=unserialize($info_user['badges']);
$amis=unserialize($info_user['amis']);
$abonnes=unserialize($info_user['suivis']);
$aime=unserialize($info_user['aime']);
$liste_demande=unserialize($info_user['attente_amis']);
$theme_url=array('defaut', 'aero.css');
$badges_url=array('beta-testeur.png', 'donateur.png', 'idees.png', 'inscrit.png', 'vacancier.png');
$badges_nom=array('L\'experimenteur, j\'ai participé à une session de bêta-test !', 'Le donateur, j\'ai réalisé un don à Witzing', 'La lumière, j\'ai donné des conseils pour Witzing', 'Le premier pas, je viens de m\'inscrire !', 'Le vacancier de retour, j\'ai passé 1 ans sans me connecter sur Witzing');
$name_profile=($_GET['id']==$_SESSION['id_membre']) ? 'Mon fil d\'actu' : htmlspecialchars($info_user['pseudo']);
if(isset($_POST['post_text']) && isset($_POST['destinataire']) && isset($_FILES['fichier_photo']) && isset($_POST['photo_change']) && strlen($_POST['post_text'])<=900)
{
	create_status($_POST['post_text'], $_POST['destinataire'], $_FILES['fichier_photo'], $_POST['photo_change'], $bdd);
}
if(!isset($_GET['id']))
{
	header('Location: index.php?page=profile&id=' . $_SESSION['id_membre']);
}
include_once('data/view/profile.php');
?>
