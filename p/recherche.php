<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
if(!isset($_GET['recherche_cle']) && !strlen($_GET['recherche_cle'])<50)
{
	header('Location: index.php?id=' . $_SESSION['id_membre']);
}
$recherche_regex=preg_replace('#\.#isU', '\.', $_GET['recherche_cle']);
include('../licence_include.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,user-scalable=no">
<meta name="keywords" content="Witzing"/>
<title>Witzing - Recherche</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
	<div id="conteneur_result">
		<?php
		if(!(isset($_GET['interet'])))
		{
		?>
		<p class="categorie_rech">Résultat dans membres :</p>
		<?php
			$test_req=$bdd->prepare('SELECT * FROM membres WHERE pseudo REGEXP :recherche ORDER BY id_membre DESC LIMIT 0, 50');
			$test_req->execute(array(
				'recherche' => $recherche_regex,
				));
			$test=$test_req->fetch();
			$recherche_req=$bdd->prepare('SELECT * FROM membres WHERE pseudo REGEXP :recherche ORDER BY id_membre DESC LIMIT 0, 50');
			$recherche_req->execute(array(
				'recherche' => $recherche_regex,
				));
			if($test)
			{
				while($recherche=$recherche_req->fetch())
				{
				?>
				<div class="result_rech">
					<a href="index.php?id=<?php echo $recherche['id_membre']; ?>"><img src="<?php echo htmlspecialchars($recherche['avatar']) ?>" alt="avatar" class="avatar_rech"></a>
					<a href="index.php?id=<?php echo $recherche['id_membre']; ?>"><p><?php echo htmlspecialchars($recherche['pseudo']); ?><img src="../data/style/led<?php if(membreconnecte($bdd, $recherche['id_membre'])) { echo '1'; } else { echo '0'; } ?>.png" class="led_statut"/></p></a>
				</div>
				<?php
				}
			}
			else
			{
				?>
				<div class="result_rech">
					<img src="../data/style/interro.png" class="avatar_rech"/>
					<p>Désolé, pas de résultat pour "<?php echo $_GET['recherche_cle'] ; ?>"</p>
				</div>
				<?php
			}
			$test_req->closeCursor();
			$recherche_req->closeCursor();
		}
		?>
		<p class="categorie_rech">Résultat dans les posts :</p>
		<?php
		$test_req_post=$bdd->prepare('SELECT * FROM statuts WHERE contenu_statut REGEXP :recherche ORDER BY date_statut DESC LIMIT 0, 50');
		$test_req_post->execute(array(
			'recherche' => $recherche_regex,
			));
		$test_post=$test_req_post->fetch();
		$recherche_req_post=$bdd->prepare('SELECT * FROM statuts WHERE contenu_statut REGEXP :recherche ORDER BY date_statut DESC LIMIT 0, 50');
		$recherche_req_post->execute(array(
			'recherche' => $recherche_regex,
			));
		if($test_post)
		{
			while($post=$recherche_req_post->fetch())
			{
				$req_info_membre_post=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id_membre');
				$req_info_membre_post->execute(array(
					'id_membre' => $post['ecrivain_statut'],
					));
				$info_membre_post=$req_info_membre_post->fetch();
			?>
			<div class="result_rech">
				<a href="index.php?id=<?php echo $info_membre_post['id_membre']; ?>"><img src="<?php echo htmlspecialchars($info_membre_post['avatar']) ?>" alt="avatar" class="avatar_rech"/></a>
				<a href="lecture_post.php?id=<?php echo $post['id_statut']; ?>"><p>"<?php echo htmlspecialchars(coupeur(photo_statut_desactiv($post['contenu_statut']))); ?>"  Publié <?php $post['date_statut']=preg_replace_callback('#(.+)-(.+)-(.+) (.+):(.+):(.+)#i', 'dateur', $post['date_statut']);echo $post['date_statut'];?> par <?php echo htmlspecialchars($info_membre_post['pseudo']);if($info_membre_post['id_membre']==$post['membre_statut']) { echo ' (sur son fil d\'actu)'; } else { echo ' (sur un autre fil d\'actu)'; } ?><img src="../data/style/led<?php if(membreconnecte($bdd, $info_membre_post['id_membre'])) { echo '1'; } else { echo '0'; } ?>.png" class="led_statut"/></p></a>
			</div>
			<?php
			}
		}
		else
		{
			?>
			<div class="result_rech">
				<img src="../data/style/interro.png" class="avatar_rech"/>
				<p>Désolé, pas de résultat pour "<?php echo $_GET['recherche_cle'] ; ?>"</p>
			</div>
			<?php
		}
		$test_req_post->closeCursor();
		$recherche_req_post->closeCursor();
			?>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.php"></script>
</body>
</html>
