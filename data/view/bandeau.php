<?php
$urlbase=$_SERVER['REQUEST_URI'];
?>
<div id="bandeau">
<a href="#" title="Cliquer pour déplier">
	<img src="<?php echo htmlspecialchars($info_user['avatar']); ?>" alt="avatar" id="avatar_member_band"/>
	<p id="name_member"><?php echo htmlspecialchars($info_user['pseudo']); ?><img src="data/style/fleche_bas.png" alt="fleche bas" id="arrow_down"/></p>
</a>
<div class="separator_band"></div>
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
	<ul id="liste_smile">
	</ul>
	<img src="" alt="img" onclick="lightbox('', false);" id="lightbox_img"/>
	<span id="fermer_lightbox" onclick="lightbox('', false);">Fermer</span>
</div>
<div id="conteneur_mm_co">
	<p id="amis_connecte_titre">Chargement en cours ...</p>
	<div class="amis_connecte">
	</div>
</div>
<img src="../data/style/led0.png" title="Voir mes amis connectés" id="bt_amis_co" onclick="afficher_cacher_amis();"/>
