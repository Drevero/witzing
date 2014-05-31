<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
$req_suiveur_moi=$bdd->prepare('SELECT * FROM membres WHERE suivis REGEXP :reg');
$req_suiveur_moi->execute(array(
	'reg' => '\*' . $_SESSION['id_membre'] . '\*',
	));
$suiveur_moi_array[]='';
while($suiveur_moi=$req_suiveur_moi->fetch())
{
	$suiveur_moi_array[]=$suiveur_moi['id_membre'];
}
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Découvrir</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
	<div id="conteneur_recherche">
		<form name="recherche" method="GET" action="recherche.php">
			<input type="text" maxlength="50" onblur="" autocomplete="off" onkeyup="recherche_membre(this.value);" placeholder="Recherchez une personne, un projet ..." <?php if(isset($_GET['recherche_cle'])) { echo 'value="' . htmlspecialchars($_GET['recherche_cle']) . '"'; } ?> name="recherche_cle" id="recherche" onclick="notif_out();"/>
		</form>
		<div id="suggest_membre">
		</div>
	</div>
	<?php
	$positive=true;
	$req_nmb_mm=$bdd->query('SELECT COUNT(*) AS nmb_mm FROM membres');
	$nmb_mm=$req_nmb_mm->fetch();
	$nmb_tourbcl=0;
	$suggest_membre=false;
	if($nmb_mm)
	{
		while($positive)
		{
			$nmb_tourbcl++;
			$id_aleatoire=mt_rand(0, $nmb_mm['nmb_mm']);
			$req_infos_mm=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
			$req_infos_mm->execute(array(
				'id_membre' => $id_aleatoire,
				));
			$infos_mm=$req_infos_mm->fetch();
			if($infos_mm)
			{
				if($infos_mm['id_membre']!=$_SESSION['id_membre'])
				{
					if(!in_array($infos_mm['id_membre'], $liste_amis))
					{
						$liste_attente_amis_lui=explode('*', $infos_mm['attente_amis']);
						if(!in_array($_SESSION['id_membre'], $liste_attente_amis_lui))
						{
							?>
							<a href="index.php?id=<?php echo $infos_mm['id_membre']; ?>" id="lien_membre_aleatoire"><img src="<?php echo $infos_mm['avatar']; ?>" alt="Avatar" id="avatar_membre_aleatoire"/></a>
							<p id="bulle_membre_aleatoire"><img src="../data/style/fleche_gauche.png" alt="Fleche gauche"/>Vous connaissez peut-être <a href="index.php?id=<?php echo $infos_mm['id_membre']; ?>"><span id="hashtag_witz">@<?php echo htmlspecialchars($infos_mm['pseudo']); ?></span></a> ?</p>
							<?php
							$positive=false;
							$suggest_membre=true;
						}
					}
				}
			}
			if($nmb_tourbcl>300)
			{
				$positive=false;
			}
		}
	}
	?>
	<div id="conteneur_flux_dynamique"<?php if($suggest_membre) { echo ' class="suggest_true"'; } ?>>
		<?php
		$tour_boucle=0;
		for($i=0;$i<count($liste_amis);$i++)
		{
			if($liste_amis[$i]!='' && $tour_boucle<20)
			{
				$req_status=$bdd->prepare('SELECT * FROM statuts WHERE ecrivain_statut = :membre ORDER BY date_statut DESC LIMIT 0, 2');
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
							<p class="ouvrir_post"><a href="lecture_post.php?id=<?php echo $statuts['id_statut']; ?>" title="Ouvrir le statut">Ouvrir le statut </a><span class="slash">/</span><a href="index.php?partager_post=<?php echo $statuts['id_statut']; ?>&amp;id=<?php echo $statuts['membre_statut']; ?>" title="Partager le statut"> Partager le statut <span class="typo">o</span></a></p>
							<?php
							if($statuts['partage']=='0')
							{
							?>
								<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> ';$statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
							<?php
							}
							else
							{
								$req_membre_partage=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
								$req_membre_partage->execute(array(
									'id_membre' => $statuts['partage'],
									));
								$membre_partage=$req_membre_partage->fetch();
							?>
								<p class="date_createur_post">Partagé par <?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> '; ?> de <a href="index.php?id=<?php echo $membre_partage['id_membre']; ?>">@<?php echo htmlspecialchars($membre_partage['pseudo']); ?></a> <?php $statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
							<?php
							}
							?>
						</div>
						<p class="texte_post_cont"><?php echo photo_statut(emoticons(linkeur(hashtageur(citeur_mm(nl2br(htmlspecialchars($statuts['contenu_statut']))))))); ?></p>
					</div>
					<?php
					$req_membre_statut->closeCursor();
				}
				$req_status->closeCursor();
				$tour_boucle++;
			}
		}
		for($i=0;$i<count($suiveur_moi_array);$i++)
		{
			if($suiveur_moi_array[$i]!='' && $tour_boucle<40 && !in_array($suiveur_moi_array[$i], $liste_amis))
			{
				$req_status=$bdd->prepare('SELECT * FROM statuts WHERE ecrivain_statut = :membre ORDER BY date_statut DESC LIMIT 0, 2');
				$req_status->execute(array(
					'membre' => $suiveur_moi_array[$i],
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
							<p class="ouvrir_post"><a href="lecture_post.php?id=<?php echo $statuts['id_statut']; ?>" title="Ouvrir le statut">Ouvrir le statut </a><span class="slash">/</span><a href="index.php?partager_post=<?php echo $statuts['id_statut']; ?>&amp;id=<?php echo $statuts['membre_statut']; ?>" title="Partager le statut"> Partager le statut <span class="typo">o</span></a></p>
							<?php
							if($statuts['partage']=='0')
							{
							?>
								<p class="date_createur_post"><?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> ';$statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
							<?php
							}
							else
							{
								$req_membre_partage=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
								$req_membre_partage->execute(array(
									'id_membre' => $statuts['partage'],
									));
								$membre_partage=$req_membre_partage->fetch();
							?>
								<p class="date_createur_post">Partagé par <?php echo '<a href="index.php?id=' . $statuts['ecrivain_statut'] . '">@' . htmlspecialchars($membre_statut['pseudo']) . '</a> '; ?> de <a href="index.php?id=<?php echo $membre_partage['id_membre']; ?>">@<?php echo htmlspecialchars($membre_partage['pseudo']); ?></a> <?php $statuts['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $statuts['date_statut']);echo $statuts['date_statut']; ?></p>
							<?php
							}
							?>
						</div>
						<p class="texte_post_cont"><?php echo photo_statut(emoticons(linkeur(hashtageur(citeur_mm(nl2br(htmlspecialchars($statuts['contenu_statut']))))))); ?></p>
					</div>
					<?php
					$req_membre_statut->closeCursor();
				}
				$req_status->closeCursor();
				$tour_boucle++;
			}
		}
		?>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.js"></script>
</body>
</html>
