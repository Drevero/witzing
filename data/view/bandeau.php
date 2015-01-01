<?php
$urlbase=$_SERVER['REQUEST_URI'];
$info_me=getUserInfo($_SESSION['id_membre'], $bdd);
?>
<div id="bandeau" onmouseleave="menu_activities(false);">
<div id="more" onclick="menu_activities(true);">
<img src="<?php echo htmlspecialchars($info_me['avatar']); ?>" alt="avatar" id="avatar_member_band"/>
<p id="name_member"><img src="data/style/fleche_bas.png" alt="fleche bas" id="arrow_down"/></p>
</div>
<div id="info_bann">
	<p id="info_bann_text">...</p>
</div>
<div id="menu_bann">
	<ul>
		<li><a href="index.php?page=profile&id=<?php echo $_SESSION['id_membre']; ?>">Mon fil d'actu</a></li>
		<li><a href="index.php?page=news">Actualités</a></li>
		<li><a href="index.php?page=taverne">La taverne</a></li>
		<li><a href="index.php?page=settings">Paramètres</a></li>
		<li><a href="index.php?dec" class="logout">Déconnexion</a></li>
	</ul>
</div>
<div id="search_tool">
	<input type="text" placeholder="Chercher un amis, un lieu, un groupe ..." id="search"/>
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
	<ul id="liste_smile">
	</ul>
	<img src="" alt="img" onclick="lightbox('', false);" id="lightbox_img"/>
	<span id="fermer_lightbox" onclick="lightbox('', false);">Fermer</span>
</div>
