<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
session_start();
include('../data/bdd.php');
include('../data/standard.php');
$type=Array('amis', 'suivis', 'aime', 'abonnements');
if(!in_array($_GET['req'], $type) && !isset($_GET['id_liste']))
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
<title>Witzing - Listage</title>
<link rel="stylesheet" href="../data/style/style.php"/>
<link rel="icon" href="../data/style/logo.png" type="image/png" />
</head>
<body>
<?php
include('../data/bandeau.php');
?>
<div id="conteneur_membre">
	<div id="conteneur_result">
		<p class="categorie_rech">Résultats</p>
		<?php
		if($_GET['req']!='abonnements')
		{
			$test_req=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id ORDER BY derniere_con LIMIT 0, 800');
			$test_req->execute(array(
				'id' => $_GET['id_liste'],
				));
			$test=$test_req->fetch();
			if($test)
			{
				$liste_chose=$test[$_GET['req']];
				$liste_chosev=explode('*', $liste_chose);
				for($i=0;$i<count($liste_chosev);$i++)
				{
					if($liste_chosev[$i]!='')
					{
						$info_membre_chose=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
						$info_membre_chose->execute(array(
							'id' => $liste_chosev[$i],
							));
						$info_membrec=$info_membre_chose->fetch();
						?>
						<div class="result_rech">
							<a href="index.php?id=<?php echo $info_membrec['id_membre']; ?>"><img src="<?php echo htmlspecialchars($info_membrec['avatar']) ?>" alt="avatar" class="avatar_rech"></a>
							<a href="index.php?id=<?php echo $info_membrec['id_membre']; ?>"><p><?php echo htmlspecialchars($info_membrec['pseudo']); ?><img src="../data/style/led<?php if(membreconnecte($bdd, $info_membrec['id_membre'])) { echo '1'; } else { echo '0'; } ?>.png" class="led_statut"/></p></a>
						</div>
				<?php
					}
				}
				if(count($liste_chosev)==1)
				{
					header('Location: index.php?id=' . $_GET['id_liste']);
				}
			}
			$test_req->closeCursor();
		}
		else
		{
			$test_req=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id ORDER BY derniere_con LIMIT 0, 800');
			$test_req->execute(array(
				'id' => $_GET['id_liste'],
				));
			$test=$test_req->fetch();
			if($test)
			{
				$abonnements=$bdd->prepare('SELECT * FROM membres WHERE suivis REGEXP :id AND id_membre != :id_membre LIMIT 0, 800');
				$abonnements->execute(array(
					'id' => '\*' . $_GET['id_liste'] . '\*',
					'id_membre' => $_GET['id_liste'],
				));
				$liste_abo='';
				while($abo=$abonnements->fetch())
				{
					$liste_abo.='*' . $abo['id_membre'] . '*';
				}
				$array_abo=explode('*', $liste_abo);
				for($i=0;$i<count($array_abo);$i++)
				{
					if($array_abo[$i]!='')
					{
						$info_membre_abo=$bdd->prepare('SELECT * FROM membres WHERE id_membre = :id');
						$info_membre_abo->execute(array(
							'id' => $array_abo[$i],
							));
						$info_membrec=$info_membre_abo->fetch();
						?>
						<div class="result_rech">
							<a href="index.php?id=<?php echo $info_membrec['id_membre']; ?>"><img src="<?php echo htmlspecialchars($info_membrec['avatar']) ?>" alt="avatar" class="avatar_rech"></a>
							<a href="index.php?id=<?php echo $info_membrec['id_membre']; ?>"><p><?php echo htmlspecialchars($info_membrec['pseudo']); ?><img src="../data/style/led<?php if(membreconnecte($bdd, $info_membrec['id_membre'])) { echo '1'; } else { echo '0'; } ?>.png" class="led_statut"/></p></a>
						</div>
				<?php
						$info_membre_abo->closeCursor();
					}
				}
				if(count($array_abo)==1)
				{
					header('Location: index.php?id=' . $_GET['id_liste']);
				}
				$abonnements->closeCursor();
			}
			else
			{
				header('Location: index.php');
			}
			$test_req->closeCursor();
		}
		?>
	</div>
</div>
<script type="text/javascript" src="../data/witzing.js"></script>
</body>
</html>
