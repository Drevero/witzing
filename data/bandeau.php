<?php
$urlbase=$_SERVER['REQUEST_URI'];
?>
<div id="bandeau">
<div class="context_glisse <?php if(preg_match('#/p/(index\.php\?id=' . $_SESSION['id_membre'] . '|lister\.php\?req=(.+)&id_liste=' . $_SESSION['id_membre'] . ')$#', $urlbase)) { echo 'select_glisse'; } ?>" <?php if(!preg_match('#/p/(index\.php\?id=' . $_SESSION['id_membre'] . '|lister\.php\?req=(.+)&id_liste=' . $_SESSION['id_membre'] . ')$#', $urlbase)) { ?> onmouseover="context_vive(0, true);" onmouseout="context_vive(0, false);" <?php } ?>>
	<a href="index.php?id=<?php echo $_SESSION['id_membre']; ?>" title="Mon fil d'actu" class="a_context <?php if(preg_match('#/p/(index\.php\?id=' . $_SESSION['id_membre'] . '|lister\.php\?req=(.+)&id_liste=' . $_SESSION['id_membre'] . ')$#', $urlbase)) { echo 'a_select_glisse'; } ?>">Mon fil d'actu</a>
</div>
<div class="context_glisse <?php if(preg_match('#/p/(decouvrir\.php)$#', $urlbase)) { echo 'select_glisse'; } ?>" id="cg2" <?php if(!preg_match('#/p/(decouvrir\.php)$#', $urlbase)) { ?>onmouseover="context_vive(1, true);" onmouseout="context_vive(1, false);" <?php } ?>>
	<a href="decouvrir.php" title="@Découvrir" class="a_context <?php if(preg_match('#/p/(decouvrir\.php)$#', $urlbase)) { echo 'a_select_glisse'; } ?>">@Découvrir</a>
</div>
<div class="context_glisse <?php if(preg_match('#/p/salon\.php#', $urlbase)) { echo 'select_glisse'; } ?>" id="cg3" <?php if(!preg_match('#/p/salon\.php#', $urlbase)) { ?> onmouseover="context_vive(2, true);" onmouseout="context_vive(2, false);" <?php } ?>>
	<a href="salon.php" title="Le #Salon" class="a_context <?php if(preg_match('#/p/salon\.php#', $urlbase)) { echo 'a_select_glisse'; } ?>">Le #Salon</a>
</div>
<div class="context_glisse <?php if(preg_match('#/p/(parametre|cloturer_compte)\.php#', $urlbase)) { echo 'select_glisse'; } ?>" id="cg4" <?php if(!preg_match('#/p/(parametre|cloturer_compte)\.php#', $urlbase)) { ?>onmouseover="context_vive(3, true);" onmouseout="context_vive(3, false);" <?php } ?>>
	<a href="parametre.php" title="Paramètres" class="a_context <?php if(preg_match('#/p/(parametre|cloturer_compte)\.php#', $urlbase)) { echo 'a_select_glisse'; } ?>">Paramètres</a>
</div>
<div class="context_glisse" id="cg5" onmouseover="context_vive(4, true);" onmouseout="context_vive(4, false);">
	<a href="index.php?dec" class="a_context" title="Déconnexion">Déconnexion</a>
</div>
<div id="infos">
	<p id="notif_plan">0</p>
	<p id="notif_amis">0</p>
	<p id="notif_msg">0</p>
	<span class="typo notif" onclick="notif('1');">w</span>
	<span class="typo notif" onclick="notif('2');">f</span>
	<span class="typo notif" onclick="notif('3');">b</span>
	<img src="../data/style/fleche.png" alt="fleche" id="fleche"/>
	<div id="cont_inf">
		<div class="notif_conteneur" id="notif_plan_conteneur"></div>
		<div class="notif_conteneur" id="notif_msg_conteneur"></div>
		<div class="notif_conteneur" id="notif_amis_conteneur"></div>
	</div>
</div>
<select id="categorie_resp" onchange="resp_page('' + this[this.selectedIndex].value + '');">
	<option value="">Catégorie</option>
	<option value="index.php">Mon fil d'actu</option>
	<option value="decouvrir.php">@Decouvrir</option>
	<option value="salon.php">Le #Salon</option>
	<option value="parametre.php">Paramètres</option>
	<option value="index.php?dec">Deconnexion</option>
</select>
</div>
<div id="lightbox">
	<img src="" alt="img" onclick="lightbox('', false);" id="lightbox_img"/>
	<span id="fermer_lightbox" onclick="lightbox('', false);">Fermer</span>
</div>
<div id="conteneur_mm_co">
	<p id="amis_connecte_titre">Chargement en cours ...</p>
	<div class="amis_connecte">
	</div>
</div>
<img src="../data/style/led0.png" title="Voir mes amis connectés" id="bt_amis_co" onclick="afficher_cacher_amis();"/>
