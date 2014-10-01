	<div id="conteneur_gauche_profil">
		<img src="<?php echo $info_user['avatar'] ?>" alt="avatar"/>
		<div id="fenetre_stat">
			<img src="data/style/fleche.png" alt="fleche" id="fleche_fenetre_stat"/>
			<p class="amis_ico_text"><a href="lister.php?req=amis&amp;id_liste=<?php echo $info_user['id_membre']; ?>"><?php echo count($amis); ?> ami<?php if(count($amis)>1) { echo 's'; } ?></a></p>
			<p class="aime_ico_text"><a href="lister.php?req=aime&amp;id_liste=<?php echo $info_user['id_membre']; ?>"><?php echo count($aime); ?> aime<?php if(count($aime)>1) { echo 'nt'; } ?></a></p>
			<p class="stat_ico_text"><a href="lister.php?req=suivis&amp;id_liste=<?php echo $info_user['id_membre']; ?>"><?php echo count($abonnes); ?> abonne<?php if(count($abonnes)>1) { echo 's'; } ?></a></p>
			<p class="abo_ico_text"><a href="lister.php?req=abonnements&amp;id_liste=<?php echo $info_user['id_membre']; ?>">µWaitµ</a></p>
		</div>
	</div>
