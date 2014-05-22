	<div id="conteneur_gauche_profil">
		<img src="<?php echo $info_membre['avatar'] ?>" alt="avatar"/>
		<div id="fenetre_stat">
			<img src="../data/style/fleche.png" alt="fleche" id="fleche_fenetre_stat"/>
			<p class="amis_ico_text"><a href="lister.php?req=amis&amp;id_liste=<?php echo $info_membre['id_membre']; ?>"><?php if(nombre_form($info_membre['amis'])<100000000) { echo nombre_form($info_membre['amis']); } else { echo '+ de 100 000 000'; } ?> ami<?php if(nombre_form($info_membre['amis'])>1) { echo 's'; } ?></a></p>
			<p class="aime_ico_text"><a href="lister.php?req=aime&amp;id_liste=<?php echo $info_membre['id_membre']; ?>"><?php if(nombre_form($info_membre['aime'])<9000000) { echo nombre_form($info_membre['aime']); } else { echo '+ de 9 000 000'; } ?> aime<?php if(nombre_form($info_membre['aime'])>1) { echo 'nt'; } ?></a></p>
			<p class="stat_ico_text"><a href="lister.php?req=suivis&amp;id_liste=<?php echo $info_membre['id_membre']; ?>"><?php if(nombre_form($info_membre['suivis'])<900000) { echo nombre_form($info_membre['suivis']); } else { echo '+ de 900 000'; } ?> abonné<?php if(nombre_form($info_membre['suivis'])>1) { echo 's'; } ?></a></p>
			<p class="abo_ico_text"><a href="lister.php?req=abonnements&amp;id_liste=<?php echo $info_membre['id_membre']; ?>"><?php echo $nmb_abonnements['nmb_abonnement']; ?> abonnement<?php if($nmb_abonnements['nmb_abonnement']>1) { echo 's'; } ?></a></p>
		</div>
	</div>
