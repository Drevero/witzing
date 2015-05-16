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
<div id="notif_float">
<span id="notif_alert"></span>
<p id="bell_notif" onclick="switch_to_notif();">9</p>
<p id="menu_notif">4</p>
</div>
</div>
<div id="side_bar" onmouseleave="close_notif();">
	<div id="title_bar">
		<p>Notifications</p>
	</div>
	<div id="side_bar_notification">
		<div id="newspaper" class="selected" onclick="switch_to_notif();">
			<p>w</p>
		</div>
		<div id="friends_ask" onclick="switch_to_friends();">
			<p>f</p>
			<span id="notif_alert_friends"></span> 
		</div>
		<div id="content_notification">
			<div class="ask_bubble">
			<a href="profile.php">
				<img src="data/img/avatars/hebus.jpg" alt="avatar"/>
				<p>Drevero</p>
			</a>
			<p class="member_tool"><span class="accept_friend">Accepter</span> / <span class="reject_member">Refuser</span></p>
			</div>
		</div>
	</div>
</div>
<div id="lightbox">
	<div id="content_arrow_slide">
		<img src="data/style/slide_right.png" alt="img" id="slide_right_arrow"/>
	</div>
	<ul id="liste_smile">
	</ul>
	<img src="" alt="img" onclick="lightbox('', false);" id="lightbox_img"/>
	<span id="fermer_lightbox" onclick="lightbox('', false);">Fermer</span>
</div>
