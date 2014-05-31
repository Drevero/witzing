<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
if(count($liste_amis)>1000 || count($liste_suiveur)>800)
{
	header('Location: index.php?id=' . $_SESSION['id_membre']);
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - @Découvrir</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
if(nombre_form($recherche['amis'])<2)
{
	header('Location: index.php?id=' . $_SESSION['id_membre']);
}
?>
<div id="conteneur_membre">
	<div id="conteneur_flux_dynamique">
		<p id="monfil">Activités Récentes : </p>
		<?php
		$news_pr_membre=10;
		for($i=0;$i<count($liste_amis);$i++)
		{
			if($liste_amis[$i]!='')
			{
				$req_status=$bdd->prepare('SELECT * FROM statuts WHERE ecrivain_statut = :membre ORDER BY date_statut DESC LIMIT 0, ' . $news_pr_membre);
				$req_status->execute(array(
					'membre' => $liste_amis[$i],
					));
				while($statuts=$req_status->fetch())
				{
					$req_membre_statut=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id_membre');
					$req_membre_statut->execute(array(
						'id_membre' => $statuts['ecrivain_statut'],
						));
					$membre_statut=$req_membre_statut->fetch();
					?>
					<div class="post">
						<div class="contenu_post_edit">
							<p class="ouvrir_post"><a href="lecture_post.php?id=<?php echo $statuts['id_statut']; ?>" title="Ouvrir le post">Ouvrir le post <span class="typo">o</span></a><?php if($statuts['ecrivain_statut']==$_SESSION['id_membre']) { ?><a href="?id_supr_post=<?php echo $statuts['id_statut']; ?>&amp;id=<?php echo $statuts['membre_statut']; ?>" title="Supprimer le post"> Supprimer le post <span class="typo">x</span></a><?php } ?></p>
							<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> ';$statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
						</div>
						<p class="texte_post_cont"><?php echo photo_statut(emoticons(linkeur(hashtageur(citeur_mm(nl2br(htmlspecialchars($statuts['contenu_statut']))))))); ?></p>
					</div>
					<?php
					$req_membre_statut->closeCursor();
				}
				$req_status->closeCursor();
			}
		}
		$news_pr_suivis=10/count($liste_suiveur);
		for($i=0;$i<count($liste_suiveur);$i++)
		{
			if($liste_suiveur[$i]!='')
			{
				$req_status=$bdd->prepare('SELECT * FROM statuts WHERE ecrivain_statut = :membre ORDER BY date_statut DESC LIMIT 0, ' . $news_pr_suivis);
				$req_status->execute(array(
					'membre' => $liste_suiveur[$i],
					));
				while($statuts=$req_status->fetch())
				{
					$req_membre_statut=$bdd->prepare('SELECT pseudo FROM membres WHERE id_membre = :id_membre');
					$req_membre_statut->execute(array(
						'id_membre' => $statuts['ecrivain_statut'],
						));
					$membre_statut=$req_membre_statut->fetch();
					if(!(in_array($statuts['membre_statut'], $liste_amis)))
					{
					?>
					<div class="post">
						<div class="contenu_post_edit">
							<p class="ouvrir_post"><a href="lecture_post.php?id=<?php echo $statuts['id_statut']; ?>" title="Ouvrir le post">Ouvrir le post <span class="typo">o</span></a><?php if($statuts['ecrivain_statut']==$_SESSION['id_membre']) { ?><a href="?id_supr_post=<?php echo $statuts['id_statut']; ?>&amp;id=<?php echo $statuts['membre_statut']; ?>" title="Supprimer le post"> Supprimer le post <span class="typo">x</span></a><?php } ?></p>
							<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> ';$statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
						</div>
						<p class="texte_post_cont"><?php echo emoticons(linkeur(hashtageur(citeur_mm(nl2br(htmlspecialchars($statuts['contenu_statut'])))))); ?></p>
					</div>
					<?php
					}
					$req_membre_statut->closeCursor();
				}
				$req_status->closeCursor();
			}
		}
		?>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
</body>
</html>
