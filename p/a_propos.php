<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
if(isset($_SESSION['id_membre']))
{
	include('../data/standard.php');
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - À propos</title>
<link rel="stylesheet" href="../data/style/style.css"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
if(isset($_SESSION['id_membre']))
{
	include('../data/bandeau.php');
}
else
{
?>
<div id="bandeau" class="bandeau_accueil">
	<div id="cont_con">
		<form name="connexion" method="post" action="../index.php">
			<input type="mail" placeholder="Adresse Email" name="mail" maxlength="256" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
			<input type="password" placeholder="Mot de Passe" name="passe" maxlength="256" class="saisie<?php if(isset($_GET['i'])) { echo ' erreur'; } ?>"/>
			<input type="submit" value=">" id="con"/>
		</form>
	</div>
</div>
<?php
}
?>
<div id="conteneur_membre">
	<p id="titre_a_propos">À propos de Witzing</p>
	<div id="conteneur_a_propos">
		<p class="sous_titre_a_propos">Pourquoi choisir Witzing ?</p>
		<p class="texte_contenu_a_propos"><b>LIBERTÉ</b> : Witzing est un 
logiciel libre, vous pouvez l'utiliser, le modifier, le redistribuer et 
l'améliorer sans autres restrictions que celles stipulées par les termes
 de la licence <a href="../LICENCE.txt">GNU General Public License Version 3 (GPLv3)</a><br><br><b>INDÉPENDANCE</b>
 : Witzing est un réseau social indépendant, je suis libre d'innover 
sans aucune contraite pour vous offrir un service toujours meilleur<br><br><b>RESPECT</b> : Witzing connaît la Liberté d'Expression <br><br><b>DISCRÉTION</b> : Witzing ne conserve pas votre adresse IP<br><br><b>NEUTRALITÉ</b> : Witzing est totalement désintérressé par vos informations personnelles<br><br><b>LÉGÈRETÉ</b> : Witzing ne comporte pas de publicité.</p>
		<p class="sous_titre_a_propos" id="conditions_generale">Conditions Générales d'Utilisation (C.G.U.)</p>
		<p class="texte_contenu_a_propos"><b>I - Introduction</b><br><br><b>Préambule</b><br>L'objectif de ce document est de définir les droits et devoirs des utilisateurs du réseau social Witzing.<br><br><b>Définitions</b><br>Lors
 de son inscription sur le programme informatique situé à cette adresse 
web : http://www.witzing.fr/ (ci-après "Witzing"),
 l'internaute (ci-après "Membre") accepte les présentes Conditions 
Générales d'Utilisation. Chaque Membre de Witzing est qualifié par un 
titre (ci-après "Titre"), accordé lors de son inscription qui lui 
confère le droit d'utilisation des services de Witzing.<br><br/><b>II - Conditions d'utilisation</b><br/><br/><b>Conditions</b><br/>Un Membre doit se conformer à éviter les critères de modération tels que définis dans la section "Critères de modération".<br/><br/><b>Critères de modération</b><br/>Est
 considérée comme inadaptée toute donnée dont le contenu ou la forme 
incite à la haine, présente un caractère sexiste, pédopornographique 
et/ou violent.</p>
		<p class="sous_titre_a_propos">Distribution</p>
		<p class="texte_contenu_a_propos">Le code source de Witzing est disponible <a href="../distrib/witzing-0.6.tar.gz" title="Téléchargement du code source de Witzing">à cette adresse</a> selon les termes des licences suivantes : <br/><br/>- <a href="../LICENCE.txt">GNU General Public License Version 3</a> (code source) <br/><br/>- <a href="../data/fond_accueil/LICENCE.txt">GNU Lesser General Public License Version 3</a> et <a href="http://www.creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution Share-Alike 3.0</a> (images du projet <a href="http://www.gnome.org/">GNOME</a>) <br/><br/>- <a href="../data/fond_accueil/LICENCE.txt">GNU Lesser General Public License Version 3</a> (images du projet <a href="http://www.kde.org/">KDE</a>) <br/><br/>- <a href="../data/style/LICENSE.txt">Apache License Version 2.0</a> (police de caractère "OpenSans") <br/><br/>- <a href="../data/style/SIL Open Font License.txt">SIL OPEN FONT LICENSE Version 1.1</a> (police de caractère "ModernPics").</p>
		<p class="sous_titre_a_propos">Crédits</p>
		<p class="texte_contenu_a_propos">Création et programmation : Drevero, adresse email : <a href="mailto:drevero@drevero.zz.mu">drevero@drevero.zz.mu</a>, site web : <a href="http://drevero.zz.mu/" title="Site web">http://drevero.zz.mu/</a><br/><br/>Gestion publique : TheEdanox, adresse email : <a href="mailto:pro@theedanox.url.ph">pro@theedanox.url.ph</a>, site web : <a href="http://www.theedanox.url.ph/" title="Site web">http://www.theedanox.url.ph/.</a></p>
		<p class="sous_titre_a_propos">Hébergement</p>
		<p class="texte_contenu_a_propos">PulseHeberg et Olympe permettent à Witzing d'être présent sur le web (<a href="http://www.pulseheberg.com/">http://www.pulseheberg.com/</a> <a href="http://www.olympe.in/">http://www.olympe.in/</a>).</p>
	</div>
</div>
<?php
if(isset($_SESSION['id_membre']))
{
?>
<script type="text/javascript" src="../data/witzing.js"></script>
<?php
}
else
{
?>
<script type="text/javascript" src="../data/witzing_nocon.js"></script>
<?php
}
?>
</body>
</html>
