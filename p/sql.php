<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
include('../licence_include.php');
if(!isset($_SESSION['id_membre']) && $recherche['admin']!='1')
{
	header('Location: ../index.php');
}
if(isset($_POST['sql_commande']))
{
	if($req_sql=$bdd->query($_POST['sql_commande']))
	{
		$req_sql=$bdd->query($_POST['sql_commande']);
		$sql_ret=$req_sql->fetch();
		$retour='';
	}
	else
	{
		$retour='Erreur de syntaxe SQL. Veuillez revoir votre manuel de commandes.';
	}
	foreach($sql_ret as $sqlret)
	{
		$retour.=$sqlret . '<br />';
	}
	header('Location: ?rep=' . $retour);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Interpréteur SQL</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
<form name="commande_sql_form" id="commande_sql_form" method="post">
	<input type="text" name="sql_commande" placeholder="Saissisez-ici votre commande SQL" id="sql_commande"/>
	<input type="submit" value="Envoyer sql" hidden/>
</form>
<div id="resultat_sql">
	<p><?php if(isset($_GET['rep']) && $_GET['rep']!='') { echo $_GET['rep']; } else { echo 'Pas de retour SQL'; } ?></p>
</div>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
</body>
</html>
