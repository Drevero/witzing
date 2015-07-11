<?php
header("Content-type: text/css");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
@font-face {
	font-family: modernic;
	src: url('modernpics.otf');
}
@font-face {
	font-family: OpenSans;
	src: url('OpenSans-Regular.ttf');
}
@media screen and (max-width: 928px) {
	.body_accueil {
		overflow-x: hidden !important;
	}
	.html_accueil {
		background-image: none !important;
		background-color: #f4f4f4 !important;
	}
	#conteneur_inscr_dernier {
		width: 80% !important;
	}
	#conteneur_droite {
		margin-top: -90px !important;
		margin-left: 10px !important;
	}
	#conteneur_gauche_profil {
		margin: auto !important;
	}
	#pseudo_info {
		text-align: center;
	}
	.photo_statut {
		max-height: 90% !important;
		max-width: 90% !important;
	}
	#conteneur_cloturation {
		width: 100% !important;
	}
	#conteneur_social {
		margin: auto !important;
		top: 0px !important;
	}
	#conteneur_messages {
		width: 100% !important;
	}
	div.contenu_post_edit p {
		position: relative !important;
		text-align: center;
	}
	p.date_createur_post {
		position: relative !important;
		float: left;
		padding-bottom: 10px;
		margin: auto;
		width: 100%;
		top: -5px;
	}
	div#bandeau {
		height: 100px !important;
	}
	div.context_glisse {
		display: none !important;
	}
	select#categorie_resp {
		display: block !important;
	}
	div#infos {
		float: none !important;
		margin: auto !important;
	}
	div#cont_inf {
		left: -35px !important;
	}
	div#conteneur_avantages {
		position: relative !important;
		margin: auto !important;
		width: 100% !important;
		height: auto !important;
		padding-top: 5px;
		top: -50px !important;
	}
	img#plis_index {
		display: none !important;
	}
	div#conteneur_presentation #conteneur {
		position: relative !important;
		margin: auto !important;
		top: -50px !important;
		width: 100% !important;
		border-top: 1px dashed #a9a9a9;
	}
	div#conteneur_presentation #conteneur p {
		top: -10px !important;
	}
	div#conteneur_presentation {
		width: auto !important;
		background-color: #f7f7f7 !important;
	}
	form#inscr_form input {
		margin: auto;
	}
	div#cont_con {
		position: relative !important;
		margin: auto !important;
		width: 100% !important;
	}
	div#cont_con .saisie {
		margin-bottom: 8px;
		width: 50%;
	}
	div.bandeau_accueil {
		display: none !important;
	}
	div#cont_con_mobile {
		display: block !important;
	}
	div#conteneur_membre {
		top: 0px !important
	}
	div#bandeau {
		position: relative !important;
	}
	img#bt_amis_co {
		top: 0px !important;
	}
	p#amis_connecte_titre {
		top: 0px !important;
	}
	div.amis_connecte {
		top: -20px !important;
	}
	div#conteneur_mm_co {
		z-index: 200 !important;
	}
	p.texte_msg {
		width: 80%;
	}
}
html, body {
	padding: 0;
	margin: 0;
	width: 100%;
	background-size: 100%;
	background-attachment: fixed;
	background-position: center;
}
#commande_sql_form {
	margin-top: 20px;
}
#resultat_sql p {
	display: block;
	position: relative;
	color: #000000;
	font-size: 15px;
	font-family: OpenSans;
	margin-top: 0;
}
#resultat_sql {
	display: block;
	position: relative;
	border: 1px dashed #dedede;
	height: auto;
	width: 600px;
	padding: 5px;
	margin: auto;
	margin-top: 20px;
}
#sql_commande {
	display: block;
	position: relative;
	width: 600px;
	margin: auto;
	padding: 5px;
	border: 1px solid #a9a9a9;
	height: 20px;
}
.poubelle_notif {
	display: block;
	position: relative;
	width: 100%;
	margin-top: 4px !important;
	left: 0px !important;
	height: 15px;
	text-align: center;
	cursor: pointer;
	font-size: 20px !important;
	font-family: modernic !important;
}
.poubelle_notif_con {
	height: 21px !important;
	overflow: hidden;
}
.poubelle_notif:hover {
	color: #cb6868;
}
.a_img_div {
	z-index: 100;
	position: absolute;
	display: block;
	height: 50px;
	width: 50px;
}
.poubelle_fond {
	left: 165px !important;
}
#apercu_fond {
	display: none;
}
form#salon_form {
	padding-bottom: 10px;
}
img#bt_amis_co {
	display: block;
	position: fixed;
	left: 0px;
	z-index: 500;
	top: 64px;
	height: 10px;
	background: white;
	border: 1px solid #c8c8c8;
	border-top: 0;
	cursor: pointer;
	padding: 5px;
	border-radius: 0px 0px 10px 0px;
}
div.amis_connecte {
	display: block;
	position: relative;
	height: 65px;
	width: 100%;
	top: 42px;
	margin-bottom: -18px;
	border-bottom: 1px solid #c8c8c8;
}
div.amis_connecte:hover {
	background: #f1f1f1 !important;
	z-index: 0;
}
div.amis_connecte img {
	display: block;
	position: absolute;
	height: 50px;
	left: 5px;
	top: 10px;
	width: 50px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
}
div.amis_connecte p {
	display: block;
	position: relative;
	font-family: OpenSans;
	font-size: 18px;
	text-align: center;
	top: 22.5px;
}
div.amis_connecte p a {
	color: #000000;
}
p#amis_connecte_titre {
	display: block;
	font-family: OpenSans;
	font-size: 18px;
	position: relative;
	text-align: center;
	top: 65px;
	z-index: 2;
	background-color: white;
	color: #777777;
	border-bottom: 1px solid #c8c8c8;
	padding-bottom: 20px;
}
div#conteneur_mm_co {
	display: none;
	position: fixed;
	left: 0px;
	height: 100%;
	width: 300px;
	border: 1px solid #c8c8c8;
	background-color: white;
	z-index: 90;
	overflow-y: auto;
	top: 0px;
}
div.tuto_inscr {
	height: 120px !important;
	padding-bottom: 20px !important;
}
div#cont_con_mobile {
	background-color: #f4f4f4;
	display: none;
	position: relative;
	width: 100%;
	top: -50px;
	padding-top: 10px;
	border-bottom: 1px dashed #a9a9a9;
	padding-bottom: 10px;
	height: 85px;
}
div#cont_con_mobile input.saisie {
	display: block;
	position: relative;
	width: 50%;
	margin: auto;
	margin-top: 10px;
}
input#con_mobile {
	opacity: 0;
}
a.supr_compte_mm {
	display: inline-block;
	position: relative;
	font-size: 15px;
	top: -12px;
	left: 10px;
}
.slash {
	color: #777777;
	font-family: OpenSans;
}
img#collier_felicitation {
	display: block;
	position: absolute;
	height: 50px;
}
select#categorie_resp {
	display: none;
	position: relative;
	top: 5px;
	z-index: 0;
	width: 100px;
	margin: auto;
}
span#fermer_lightbox {
	display: block;
	width: 100%;
	text-align: center;
	color: #cb6868;
	font-family: OpenSans;
	font-size: 15px;
	cursor: pointer;
}
div#lightbox img {
	display: block;
	max-height: 95%;
	cursor: pointer;
	max-width: 95%;
	width: auto;
	margin: auto;
	margin-top: 1%;
	background-color: #1b1b1b;
}
div#lightbox ul {
	display: block;
	position: relative;
	padding-right: 20px;
	padding-left: 0px;
	padding-top: 0px;
	height: 300px;
	overflow-y: auto;
}
#bt_ouvrir_smile {
	display: block;
	position: relative;
	float: right;
	border-left: 1px solid #a9a9a9;
	left: 3px;
	top: 0px;
	height: 28px;
	cursor: pointer;
	opacity: 0.5;
	padding-left: 5px;
}
#bt_ouvrir_smilesalon {
	display: block;
	position: relative;
	float: right;
	border-left: 1px solid #a9a9a9;
	left: -38px;
	top: -4px;
	height: 28px;
	cursor: pointer;
	opacity: 0.5;
	padding-left: 5px;
}
#bt_ouvrir_smilesalon:hover {
	opacity: 1;
}
#bt_ouvrir_smile:hover {
	opacity: 1;
}
#bt_ouvrir_smilecomment {
	display: block;
	position: relative;
	float: right;
	border-left: 1px solid #a9a9a9;
	left: -15px;
	top: -7px;
	height: 23px;
	cursor: pointer;
	opacity: 0.5;
	padding-left: 5px;
}
#bt_ouvrir_smilecomment:hover {
	opacity: 1;
}
#bt_ouvrir_smilestatut {
	display: block;
	position: relative;
	float: right;
	border-left: 1px solid #a9a9a9;
	border-top: 1px solid #a9a9a9;
	left: -10px;
	top: -14px;
	height: 23px;
	cursor: pointer;
	opacity: 0.5;
	padding-left: 2px;
}
#bt_ouvrir_smilestatut:hover {
	opacity: 1;
}
div#lightbox li {
	display: block;
	float: left;
	margin-left: 20px;
	margin-top: 20px;
}
div#lightbox {
	display: none;
	position: fixed;
	z-index: 1000;
	height: 100%;
	top: 0%;
	width: 100%;
	left: 0%;
	background-color: #1b1b1b;
}
.badge {
	display: inline-block;
	position: relative;
	height: 50px;
	width: 50px;
	top: 10px;
	left: 0px;
	margin-left: 10px;
}
div#boite_plus_info_mm p {
	display: block;
	position: relative;
	font-family: OpenSans;
	color: #505050;
	font-size: 15px;
	top: -5px;
	left: 10px;
}
p#bt_plus_info_mm {
	font-family: OpenSans;
	color: #505050;
	display: block;
	cursor: pointer;
	font-size: 15px;
	position: relative;
	top: -40px;
}
p#bt_plus_info_mm.moi {
	margin-bottom: -70px;
}
div#boite_plus_info_mm {
	display: none;
	padding: 0px;
	position: relative;
	border: 1px solid #c8c8c8;
	background-color: #f9f9f9;
	height: auto;
	width: 98%;
	top: -40px;
}
img#fleche_fenetre_stat {
	display: block;
	position: absolute !important;
	height: 14px !important;
	width: 20px !important;
	top: -13px !important;
	left: 120px !important;
}
a#retour_accueil {
	color: #68a5cb;
	font-size: 15px;
	font-family: OpenSans;
	display: block;
	position: relative;
	width: 100%;
	text-align: center;
	top: 5px;
}
.invisible {
	opacity: 0;
}
.centre_block {
	display: block;
	position: relative;
	margin: 0 !important;
	margin: auto !important;
	top: 20px;
}
.centre {
	text-align: center;
}
a#mdpperdu {
	display: block;
	position: relative;
	font-size: 12px;
	width: 100%;
	top: 1px;
	font-family: OpenSans;
	text-align: center;
	color: #68a5cb;
}
img#avatar_membre_aleatoire {
	display: block;
	position: absolute;
	height: 50px;
	width: 50px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
	top: 65px;
	left: 15px;
}
p#bulle_membre_aleatoire img {
	display: block;
	position: absolute;
	left: -14px;
}
p#bulle_membre_aleatoire {
	display: block;
	position: absolute;
	background-color: #f9f9f9;
	color: #000000;
	font-size: 15px;
	top: 60px;
	left: 90px;
	padding: 5px;
	border: 1px solid #cdcdcd;
	font-family: OpenSans;
}
p#info_inscr_inter {
	position: absolute !important;
	background-color: #f9f9f9;
	color: #777777 !important;
	font-size: 15px !important;
	top: 36px !important;
	z-index: 100;
	display: none;
	padding: 5px;
	left: -400px !important;
	border: 1px solid #cdcdcd !important;
	font-family: OpenSans;
}
img#fleche_inter {
	display: block;
	position: absolute;
	left: 395px;
}
div.videcomment {
	display: none;
}
div.publicateur_vide {
	top: -35px !important;
}
p.ouvrir_post a.supr_post:hover {
	color: #cb6868;
}
p.ouvrir_post a:hover {
	color: #68a5cb;
}
input#cont_message_salon:focus {
	border: 1px solid #68a5cb;
}
input#cont_message_salon {
	display: block;
	position: relative;
	height: 25px;
	margin: auto;
	width: 95%;
	top: 25px;
	padding-left: 5px;
	font-family: OpenSans;
	border: 1px solid #a9a9a9;
	background-color: #ffffff;
}
a.auteur_texte {
	text-decoration: none;
	color: #68a5cb;
	font-family: OpenSans;
	padding-left: 6px;
}
a.auteur_texte.parle_moi {
	margin-left: 8px;
	border-left: 4px dotted #5eb62e;
}
p.date_texte {
	color: #a2a2a2;
	display: block;
	position: relative;
	z-index: 1;
	font-family: OpenSans;
	text-align: right;
	top: 0px !important;
	left: 30px;
	z-index: 1;
	font-size: 12px !important;
}
span.date_texte {
	color: #a2a2a2;
	z-index: 1;
	font-size: 15px;
	font-family: OpenSans;
}
span.repondre_membre {
	color: #a2a2a2;
	cursor: pointer;
}
span.repondre_membre:hover {
	color: #68a5cb;
}
p.texte_salon {
	display: block;
	font-family: OpenSans;
	font-size: 15px;
	position: relative;
	word-wrap: break-word;
}
p.texte_salon span.texte_parlemoi {
	background: yellow;
}
p.texte_salon a {
	text-decoration: none;
	color: #68a5cb;
	font-family: OpenSans;
}
div#conteneur_message_salon {
	display: block;
	padding-left: 15px;
	padding-right: 15px;
	height: auto;
}
p#sous_titre_salon {
	font-family: OpenSans;
	font-size: 18px;
	color: #000000;
	display: block;
	text-align: center;
	width: 70%;
	margin: auto;
}
div#cg2 {
	margin-left: 145px;
}
div#cg3 {
	margin-left: 270px;
}
div#cg4 {
	margin-left: 380px;
}
div#cg5 {
	margin-left: 505px;
}
span.citer_membre_bt {
	font-family: OpenSans;
	color: #68a5cb;
}
div.select_glisse {
	border-bottom: 4px solid #68a5cb;
}
div.select_glisse_dec {
	border-bottom: 4px solid #cb6868;
}
a.a_select_glisse {
	color: #68a5cb !important;
}
div.context_glisse {
	display: block;
	position: absolute;
	height: 60px;
	top: 0px;
	width: auto;
	-moz-transition: all 0.1s ease-in-out;
	-o-transition: all 0.1s ease-in-out;
	-webkit-transition: all 0.1s ease-in-out;
	-ms-transition: all 0.1s ease-in-out;
	transition: all 0.1s ease-in-out;
}
div.context_glisse a {
	font-family: OpenSans;
	text-decoration: none;
	display: block;
	top: 18px;
	margin-left: 15px;
	margin-right: 15px;
	position: relative;
	font-size: 18px;
	color: #505050;
	-moz-transition: all 0.1s ease-in-out;
	-o-transition: all 0.1s ease-in-out;
	-webkit-transition: all 0.1s ease-in-out;
	-ms-transition: all 0.1s ease-in-out;
	transition: all 0.1s ease-in-out;
}
p#pres_witzing a {
	display: block;
	position: relative;
	color: #68a5cb;
	text-decoration: none;
	width: 100%;
	display: block;
	text-align: center;
	margin-top: 0px;
	-moz-transition: all 0.1s ease-in-out;
	-o-transition: all 0.1s ease-in-out;
	-webkit-transition: all 0.1s ease-in-out;
	-ms-transition: all 0.1s ease-in-out;
	transition: all 0.1s ease-in-out;
}
p#pres_witzing a:hover {
	color: #397fab;
}
p#titre_witzing_pres {
	display: block;
	position: relative;
	font-size: 32px;
	font-family: OpenSans;
	color: #2e2e2e;
	margin-top: 15px;
	text-align: center;
}
p#pres_witzing {
	display: block;
	position: relative;
	font-size: 18px;
	font-family: OpenSans;
	color: #2e2e2e;
	margin-top: -20px;
}
span#hashtag_witz {
	color: #68a5cb;
}
#inscr_form {
	display: block;
	margin-top: -15px;
}
div#conteneur {
	width: 330px;
	padding-left: 15px;
	padding-bottom: 5px;
	margin-left: 562px;
	margin-top: 38px;
	position: absolute;
	background-color: #f4f4f4;
}
div#conteneur p {
	font-size: 20px;
	color: #505050;
	text-align: center;
	left: -10px;
	top: -5px;
	position: relative;
	font-family: OpenSans;
}
div#conteneur_avantages {
	width: 520px;
	height: 300px;
	position: absolute;
	padding-left: 15px;
	padding-bottom: 5px;
	background-color: #f4f4f4;
}
img#plis_index {
	display: block;
	margin-left: 535px;
	position: absolute;
}
p.supr_notif_bt {
	display: block;
	position: absolute;
	color: #722a2a !important;
	left: 2px !important;
	top: -15px !important;
	font-family: modernic !important;
	font-size: 18px;
	cursor: pointer;
}
div.membre_result_rech {
	display: block;
	position: relative;
	height: 60px;
}
div.membre_result_rech img {
	height: 50px;
	width: 50px;
	display: block;
	position: absolute;
	left: 10px;
	top: -3px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
}
div.membre_result_rech a {
	color: #000000;
	text-decoration: none;
}
div.membre_result_rech p {
	font-family: OpenSans;
	display: block;
	position: relative;
	left: 70px;
	top: 9px;
	width: 10px;
	font-size: 16px;
}
div#conteneur_recherche {
	display: block;
	position: relative;
	height: 25px;
	margin: auto;
	width: 98%;
	top: 15px;
}
.notif_select {
	border-bottom: 3px solid #68a5cb;
}
#apercu_photo {
	display: none;
}
#logo_witzing {
	display: block;
	position: absolute;
	left: 15px;
	height: 40px;
	top: 10px;
}
p.texte_nouveau_statut {
	display: block;
	position: relative;
	font-family: OpenSans;
	font-size: 15px;
	color: black;
	top: 10px;
	text-align: center;
	word-wrap: break-word;
}
p#texte_intro a {
	color: #1470d9;
}
div#conteneur_a_propos {
	position: relative;
	padding: 10px;
	height: auto;
	padding-bottom: 10px;
	top: -20px;
}
p.sous_titre_a_propos {
	font-family: OpenSans;
	color: #000000;
	font-size: 25px;
	display: block;
	position: relative;
	width: 100%;
	text-align: left;
}
p.texte_contenu_a_propos a {
	color: #1470d9;
}
p.texte_contenu_a_propos {
	font-size: 15px;
	color: #000000;
	margin-left: 20px;
	font-family: OpenSans;
}
p#titre_a_propos {
	font-family: OpenSans;
	color: #000000;
	font-size: 30px;
	display: block;
	position: relative;
	width: 100%;
	text-align: center;
}
input#annuler_compte_confirm {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 200px;
	margin: auto;
	display: block;
	cursor: pointer;
	margin-top: 20px;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
input#creer_compte_confirm {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 200px;
	margin: auto;
	display: block;
	cursor: pointer;
	margin-top: 10px;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
img.avatar_inscr {
	border: 1px solid grey;
	margin-top: 50px !important;
}
span.vraiv {
	color: green;
}
p#texte_intro {
	font-size: 15px;
	color: #000000;
	font-family: OpenSans;
	position: relative;
	display: block;
}
div#conteneur_inscr_dernier {
	position: relative;
	width: 750px;
	height: 480px;
	margin: auto;
}
p#info_utile_inscr {
	color: #777777;
	font-family: OpenSans;
	font-size: 15px;
	top: 10%;
	text-align: center;
	display: block;
	position: relative;
}
input#cloturer_compte_confirm {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 200px;
	margin: auto;
	display: block;
	cursor: pointer;
	margin-top: 30px;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
p#infos_cloturation {
	font-family: OpenSans;
	font-size: 15px;
	color: #000000;
	display: block;
	position: relative;
}
div#conteneur_cloturation {
	position: relative;
	width: 800px;
	padding-bottom: 70px;
	height: 500px;
	margin: auto;
}
input#bt_retour_discu {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 180px;
	margin: auto;
	top: 20px;
	display: block;
	cursor: pointer;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
.avat_msg_droite {
	position: relative !important;
	float: left !important;
	right: 20px;
    top: 10px !important;
    left: -10px !important;
}
.texte_msg_droite img.mini_img {
	float: right;
}
input#afficher_plus_msg {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 180px;
	margin: auto;
	top: 0px;
	display: block;
	cursor: pointer;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
a#archive_lien:hover {
	color: #777777;
}
img.mini_img {
	display: block;
	position: relative;
	height: auto;
	width: auto;
	max-height: 200px;
	max-width: 200px;
	padding-bottom: 15px;
	padding-top: 15px;
}
a#archive_lien {
	font-family: OpenSans;
	display: block;
	position: relative;
	text-align: center;
	top: 10x;
	border: 1px solid #a9a9a9;
	background-color: #f9f9f9;
	color: #6d6d6d;
	margin: auto;
	width: 152px;
	font-family: OpenSans;
	font-size: 18px;
}
.pas_afficher {
	opacity: 0;
	cursor: default !important;
}
input#afficher_plus {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 180px;
	margin: auto;
	margin-top: 5px;
	display: block;
	cursor: pointer;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
p.no_message {
	display: block;
	position: relative;
	font-family: OpenSans;
	text-align: center;
	font-size: 15px;
	color: #777777;
	top: 255px;
}
img.photo_statut {
	display: block;
	position: relative;
	height: auto;
	width: auto;
	max-height: 500px;
	max-width: 500px;
	margin: auto;
	margin-top: 15px;
}
input#fichier_photo {
	display: none;
}
input.photo_post_bt:hover {
	cursor: pointer;
}
input.photo_post_bt {
	display: block;
	position: absolute;
	font-size: 20px;
	font-family: modernic;
	width: 30px;
	padding-bottom: 5px;
	margin-top: 23px;
	left: -1px;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
	border-left: 0px;
	border-bottom: 0px;
}
.fond_fil_bt {
	display: block;
	position: absolute !important;
	font-size: 20px !important;
	font-family: modernic !important;
	width: 30px !important;
	padding-bottom: 5px;
	height: 28px !important;
	margin-left: 50px !important;
	margin-top: -25px !important;
	background-color: #f9f9f9 !important;
	border: 1px solid #a9a9a9 !important;
	cursor: pointer;
}
p#info_utile {
	color: #777777;
	font-family: OpenSans;
	font-size: 15px;
	top: 10px;
	text-align: center;
	display: block;
	position: relative;
}
input#fichier_avat {
	display: none;
}
a {
	text-decoration: none;
}
input#cloturer_compte {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 280px;
	margin: auto;
	display: block;
	cursor: pointer;
	margin-top: 15px;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
input#plus_witzing {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 280px;
	margin: auto;
	display: block;
	cursor: pointer;
	margin-top: 15px;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
input#sauvegarder_modif_compte {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 280px;
	margin: auto;
	margin-top: 5px;
	display: block;
	cursor: pointer;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
	background-size: 20px;
	background-repeat: no-repeat;
	background-position: center;
}
a#bouton_ouvrir_salon {
	position: relative;
	font-family: Opensans;
	color: #6d6d6d;
	font-size: 17px;
	width: 280px;
	margin: auto;
	margin-top: 5px;
	display: block;
	text-align: center;
	text-decoration: none;
	padding: 2px;
	top: 40px;
	cursor: pointer;
	background-color: #f9f9f9;
	border: 1px solid #a9a9a9;
}
img#avatar_apercu:hover {
	cursor: pointer;
}
img#avatar_apercu {
	height: 200px;
	display: block;
	position: relative;
	margin: auto;
	width: 200px;
	top: -15px;
	-moz-border-radius: 20px;
	-o-border-radius: 20px;
	-webkit-border-radius: 20px;
	-ms-border-radius: 20px;
	border-radius: 20px;
}
p#texte_photo_profil {
	font-size: 15px;
	color: #000000;
	font-family: OpenSans;
	text-align: center;
	position: relative;
	display: block;
	top: -20px;
}
input#createur_badge {
	font-family: Opensans;
	color: #000000;
	font-size: 15px;
	width: 235px;
	left: 5px;
	display: block;
	position: relative;
	background-color: #ffffff;
	padding-left: 5px;
	border: 1px solid #a9a9a9;
}
form#form_mod input {
	position: absolute;
	font-family: Opensans;
	color: #000000;
	font-size: 15px;
	width: 235px;
	left: 120px;
	background-color: #ffffff;
	padding-left: 5px;
	border: 1px solid #a9a9a9;
}
form#form_mod label {
	font-size: 15px;
	color: #000000;
	font-family: OpenSans;
}
p#parametre_compte_texte {
	font-family: OpenSans;
	color: #000000;
	font-size: 30px;
	display: block;
	position: relative;
	width: 100%;
	text-align: center;
}
#conteneur_intro_salon {
	height: 310px;
}
div#conteneur_parametre {
	position: relative;
	width: 370px;
	padding-top: 20px;
	padding-bottom: 70px;
	height: 610px;
	margin: auto;
}
p#texte_infos_msg {
	font-family: OpenSans;
	color: #4e4e4e;
	font-size: 15px;
	display: block;
	position: absolute;
	width: 100%;
	top: -40px;
	text-align: center;
}
p.texte_msg a {
	color: #1470d9 !important;
	text-decoration: none;
}
input#cont_message:focus {
	border: 1px solid #68a5cb;
}
input#cont_message {
	display: block;
	position: absolute;
	height: 25px;
	width: 100%;
	padding-left: 5px;
	font-family: OpenSans;
	border: 1px solid #a9a9a9;
	background-color: #ffffff;
}
form#message {
	display: block;
	position: relative;
	height: 30px;
	top: 10px;
	width: 95%;
	margin: auto;
	padding-bottom: 30px;
}
p.texte_msg {
	display: block;
	position: relative;
	z-index: 1;
	top: -20px;
	font-family: OpenSans;
    padding: 5px;
    position: relative;
    color: white;
    font-size: 13px;
    border: 1px solid #0084FF;
    background: #0084FF;
    border-radius: 10px;
    left: -20px !important;
    width: auto;
    float: right;
}
.texte_msg_droite::after {
    display: block;
    position: absolute;
    height: 12px;
    width: 6px;
    left: -7px;
    top: 8px;
    content: "";
    background: url('http://witzing.net/data/style/left_message.png');
}
img.avat_msg {
	height: 50px;
	width: 50px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
	display: block;
	position: relative;
    top: 10px !important;
    float: right;
    left: -10px !important;
}
div.cadre_msg {
	display: block;
	position: relative;
	height: auto;
	padding-left: 20px;
	padding-top: 30px;
	padding-bottom: 0px;
	margin-top: -1px;
	overflow-x: hidden;
	word-wrap: break-word;
}
.cadre_msg a img {
    display: block !important;
    border-radius: 100%;
}
img#con_message {
	display: inline;
	height: 10px;
	display: inline-block;
	position: relative;
	bottom: 3px;
	margin-left: 10px;
	margin-bottom: 0px;
}
p#pseudo_converse {
	font-family: OpenSans;
	color: #000000;
	font-size: 20px;
	display: block;
	position: relative;
	width: 100%;
	text-align: center;
}
div#conteneur_messages {
	position: relative;
	min-height: 500px;
	height: auto;
	margin: auto;
	top: -20px;
}
.emoticons {
	display: inline-block;
	position: relative;
	margin-bottom: -5px;
    height: 20px !important;
}
div#conteneur_flux_dynamique {
	position: relative;
	height: auto;
	margin-left: 0px;
	margin-top: 70px;
	width: 100%;
}
div#conteneur_flux_dynamique .post {
	margin: auto !important;
	margin-top: 20px !important;
	width: 97.5% !important;
	left: -0.2% !important;
}
div.suggest_true {
	margin-top: 140px !important;
}
img.statut_con {
	display: inline;
	margin-left: 20px;
	margin-bottom: 7px;
}
p#pseudo_info a {
	text-decoration: none;
	color: #505050;
}
.comment_bulle a {
	color: #1470d9 !important;
	text-decoration: none;
}
.texte_post_cont a {
	color: #1470d9 !important;
	text-decoration: none;
}
.ecriture_statut {
	background-color: #f7f7f7 !important;
	border: 1px solid #c8c8c8 !important;
	overflow: hidden;
}
#fenetre_stat a {
	text-decoration: none;
	color: #363636;
}
.date_createur_post a {
	color: #1470d9 !important;
}
p.categorie_rech {
	position: relative;
	font-family: OpenSans;
	color: #777777;
	font-size: 20px;
	text-align: center;
}
.itera {
	background: #ffffff !important;
}
div.result_rech p {
	font-family: OpenSans;
	font-size: 20px;
	display: block;
	color: #000000;
	width: 85%;
	position: relative;
	left: 120px;
	top: 15px;
}
div.result_rech a {
	color: #000000;
	text-decoration: none;
}
img.led_statut {
	display: inline;
	margin-left: 10px;
	margin-bottom: 1px;
	height: 10px;
}
div.result_rech img.avatar_rech {
	position: absolute;
	margin-top: 10px;
	margin-left: 10px;
	height: 80px;
	width: 80px;
	background-color: #f5f5f5;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
}
div.result_rech {
	display: block;
	position: relative;
	border: 1px solid transparent;
	border-bottom: 1px solid #c8c8c8;
	border-top: 1px solid #c8c8c8;
	height: 100px;
	margin-top: -2px;
	overflow: hidden;
	background: #f5f5f5;
}
div.result_rech:hover {
	background: #f1f1f1 !important;
}
div#conteneur_result {
	position: relative;
}
a.select_b {
	background-image: url('loader.gif');
	background-repeat: no-repeat;
	background-size: 60%;
	background-position: center;
}
a.select_a {
	color: #68a5cb !important;
}
div#conteneur_social a {
	text-decoration: none;
	color: #363636;
	top: 29px;
	font-size: 25px;
	display: block;
	text-align: center;
	position: absolute;
	height: 40px;
	border: 1px solid #a9a9a9;
	font-family: OpenSans;
	background-color: #f9f9f9;
}
div#conteneur_social a.msg_bt {
	width: 60px;
	left: 360px;
}
div#conteneur_social a.amis_bt {
	width: 60px;
	left: 270px;
}
div#conteneur_social a.suivre_bt {
	width: 150px;
	left: 90px;
}
div#conteneur_social a.aime_bt {
	width: 60px;
}
div#conteneur_social {
	position: relative;
	top: -30px;
	margin-bottom: -60px;
	height: 100px;
	width: 422px;
}
input.bt_poster_comment {
	opacity: 0;
	top: 15px;
	display: block;
	position: absolute;
}
div.comment_bulle p {
	font-family: OpenSans;
	color: #111111;
	font-size: 14px;
	word-wrap: break-word;
	position: absolute;
	display: block;
	height: 60%;
	top: 10px;
	width: 88%;
	left: 80px;
	white-space: pre-wrap;
	line-height: 15px;
}
div.comment_bulle img.avatar_comment {
	height: 50px;
	width: 50px;
	position: absolute;
	left: 10px;
	top: 10px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
}
div.comment_bulle {
	position: relative;
	height: 70px;
	width: 100%;
	margin: auto;
	top: 0px;
	left: -1px;
	margin-bottom: 10px;
	margin-top: 10px;
	background-color: #f9f9f9;
	border: 1px solid #cfcfcf;
}
input.input_comment {
	display: block;
	position: relative;
	font-family: Opensans;
	color: #111111;
	font-size: 15px;
	width: 98%;
	top: 17px;
	margin: auto;
	padding-left: 5px;
	border: 1px solid #a9a9a9;
}
div.publicateur_comment {
	position: relative;
	width: 99%;
	left: 0px;
	border: 1px solid #c8c8c8;
	border-top: 0px;
	background-color: #e2e2e2;
	height: 60px;
	top: 0px;
}
div.plug_comment {
	position: relative;
	overflow: auto;
	overflow-x: hidden;
	padding-bottom: 25px;
	width: 99%;
	border: 1px solid #c8c8c8;
	background-color: #ebebeb;
	height: 150px;
	margin-top: -36px;
}
.comment_date {
	font-size: 14px;
	font-family: OpenSans;
	display: block;
	position: relative;
	left: 79px;
	top: 3px;
}
.actif_stat {
	color: #68a5cb;
}
textarea {
	padding-top: 2px;
	padding-left: 2px;
}
p.texte_post_cont {
	display: block;
	position: relative;
	font-family: OpenSans;
	font-size: 15px;
	color: black;
	margin-top: 5px;
	margin-left: 5px;
	white-space: pre-wrap;
	line-height: 15px;
	word-wrap: break-word;
}
div.contenu_post_edit p.date_createur_post {
	position: relative;
	float: right;
}
div.contenu_post_edit p {
	display: block;
	position: absolute;
	font-family: OpenSans;
	color: #272727;
	word-wrap: break-word;
	font-size: 14px;
	margin-top: 0px;
}
div.contenu_post_edit a {
	text-decoration: none;
	color: #777777;
}
div.contenu_post_edit {
	position: relative;
	height: 28px;
	background-color: white;
	margin-top: 5px;
	padding-left: 5px;
	padding-right: 5px;
}
input.publier_post:hover {
	cursor: pointer;
}
input.publier_post {
	display: block;
	position: relative;
	border: 1px solid #a9a9a9;
	background-color: #f9f9f9;
	color: #6d6d6d;
	height: 28px;
	margin: auto;
	width: 152px;
	font-family: OpenSans;
	font-size: 18px;
	margin-top: 17px;
	background-size: 20px;
	background-repeat: no-repeat;
	background-position: center;
}
div.post {
	position: relative;
	min-height: 145px;
	width: 99%;
	top: -25px;
	margin-top: 20px;
	margin-bottom: 10px;
	border: 1px solid #c8c8c8;
	background-color: #ffffff;
}
div.post textarea {
	height: 90px;
	display: block;
	position: relative;
	width: 98%;
	margin: auto;
	font-size: 15px;
	border: 1px solid #a9a9a9;
	max-height: 90px;
	min-height: 90px;
	max-width: 98%;
	min-width: 98%;
	font-family: OpenSans;
	color: #111111;
	top: 10px;
}
div.post textarea:focus {
	border: 1px solid #68a5cb;
}
p#monfil {
	font-family: OpenSans;
	color: #505050;
	font-size: 40px;
	display: block;
	position: relative;
	top: 5px;
}
p#pseudo_info {
	display: block;
	position: relative;
	font-size: 68px;
	top: 15px;
	color: #505050;
	font-family: OpenSans;
}
div#conteneur_droite {
	position: relative;
	height: auto;
	margin-left: 310px;
	margin-top: -450px;
}
div#fenetre_stat p {
	display: block;
	position: relative;
	font-size: 22px;
	color: #363636;
	font-family: OpenSans;
}
.amis_ico_text {
	top: -15px;
	left: 10px;
}
.aime_ico_text {
	top: -30px;
	left: 10px;
}
.stat_ico_text {
	top: -45px;
	left: 9px;
}
.abo_ico_text {
	top: -60px;
	left: 9px;
}
div#fenetre_stat {
	position: relative;
	height: 160px;
	border: 1px solid #c8c8c8;
	top: 25px;
	background-color: #f9f9f9;
	width: 270px;
	margin: auto;
}
div#conteneur_gauche_profil img {
	height: 200px;
	display: block;
	position: relative;
	left: 48px;
	width: 200px;
	top: 10px;
	-moz-border-radius: 20px;
	-o-border-radius: 20px;
	-webkit-border-radius: 20px;
	-ms-border-radius: 20px;
	border-radius: 20px;
}
div#conteneur_gauche_profil {
	position: relative;
	height: 450px;
	width: 300px;
}
div#conteneur_membre {
	position: relative;
	padding-bottom: 30px;
	top: 65px;
}
p.no_demande {
	display: block;
	position: relative;
	font-family: OpenSans;
	text-align: center;
	font-size: 15px;
	color: #777777;
}
div.demande_amis_p {
	position: relative;
	height: 62px;
	width: 195px;
	top: 0px;
	border-bottom: 1px solid #dedede;
}
div.demande_amis_p img {
	display: block;
	position: absolute;
	height: 50px;
	width: 50px;
	left: 5px;
	top: 5px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
}
div.demande_amis_p p {
	display: block;
	position: absolute;
	font-family: OpenSans;
	font-size: 16px;
	color: #525252;
	left: 60px;
	top: -3px;
}
div.demande_amis_p p.notif_texte {
	font-size: 12px !important;
	width: 120px;
}
a.accept {
	color: #55a25c;
}
a.refus {
	color: #b74242;
}
div.demande_amis_p span {
	display: none;
	position: absolute;
	z-index: 2;
	font-size: 30px;
	left: 2px;
	top: 30px;
}
div.demande_amis_p a {
	text-decoration: none;
}
div.demande_amis_p:hover {
	background-color: #f2f2f2;
}
div.notif_conteneur {
	display: none;
	position: relative;
	height: 100%;
	width: 194px;
	left: 0px;
	z-index: 2;
	margin-top: 0px;
}
p#notif_plan {
	position: absolute;
	z-index: 2;
	font-family: OpenSans;
	font-size: 9px;
	padding-top: 2px;
	padding-left: 0px;
	height: 13px;
	text-align: center;
	width: 14px;
	top: 22px;
	left: 25px;
	display: none;
	color: #f6f6f6;
	border: 1px solid #d95656;
	background-color: #bb4a4a;
	border-radius: 100%;
}
p#notif_amis {
	position: absolute;
	z-index: 2;
	display: none;
	font-family: OpenSans;
	font-size: 9px;
	padding-top: 2px;
	padding-left: 0px;
	height: 13px;
	width: 14px;
	top: 22px;
	left: 70px;
	color: #f6f6f6;
	text-align: center;
	border: 1px solid #d95656;
	background-color: #bb4a4a;
	border-radius: 100%;
}
p#notif_msg {
	position: absolute;
	z-index: 2;
	font-family: OpenSans;
	font-size: 9px;
	padding-top: 2px;
	padding-left: 0px;
	display: none;
	height: 13px;
	width: 14px;
	top: 22px;
	left: 120px;
	text-align: center;
	color: #f6f6f6;
	border: 1px solid #d95656;
	background-color: #bb4a4a;
	border-radius: 100%;
}
div#cont_inf {
	position: absolute;
	width: 0px;
	left: -60px;
	min-height: 0;
	max-height: 400px;
	height: auto;
	padding-bottom: 0px;
	overflow-x: hidden;
	top: 68px;
	opacity: 0;
	z-index: 1;
	border: 1px solid #cdcdcd;
	background-color: #f9f9f9;
}
a.profil_opt {
	display: block;
	position: relative;
	font-family: OpenSans;
	font-size: 15px;
	color: #313131;
	height: 22px;
	padding-top: 0px;
	text-decoration: none;
	text-align: center;
	margin-top: 5px;
}
a.profil_opt:hover {
	background-color: #f2f2f2;
}
div#notif_profil_conteneur {
	padding-bottom: 3px;
}
img#fleche {
	display: block;
	position: absolute;
	opacity: 0;
	top: 55px;
	margin-left: 58px;
}
div#infos {
	height: 60px;
	width: 140px;
	position: relative;
	float: right;
	right: 1px;
}
img#avatar_inf {
	display: inline;
	cursor: pointer;
	position: absolute;
	height: 50px;
	width: 50px;
	top: 7px;
	margin-left: 12px;
	border-radius: 10px;
	-moz-border-radius: 10px;
	-o-border-radius: 10px;
	-webkit-border-radius: 10px;
	-ms-border-radius: 10px;
}
span.notif {
	display: inline;
	position: relative;
	top: 11px;
	margin-left: 5px;
	z-index: 1;
	color: #777777;
	font-size: 45px;
}
span.notif:hover {
	color: #68a5cb;
	cursor: pointer;
}
div#bandeau {
	position: fixed;
	height: 63px;
	width: 100%;
	z-index: 100;
	border-bottom: 1px solid #c8c8c8;
	background-color: #e2e2e2;
	top: 0px;
}
div#suggest_membre {
	display: none;
	position: absolute;
	height: auto;
	width: 99.4%;
	background-color: #ffffff;
	border: 1px solid #c8c8c8;
	border-top: 0px;
	z-index: 100;
}
input#recherche {
	display: block;
	position: relative;
	height: 25px;
	width: 99%;
	padding-left: 5px;
	font-family: OpenSans;
	border: 1px solid #a9a9a9;
	background-color: transparent;
}
input.saisie {
	height: 25px;
	width: 300px;
	padding-left: 5px;
	margin-right: 30px;
	font-family: OpenSans;
	border: 1px solid #a9a9a9;
	background-color: #ffffff;
}
input#con {
	height: 29px;
	width: 25px;
	font-family: modernic;
	color: #777777;
	font-size: 19px;
	padding-bottom: 15px;
	border: 1px solid #a9a9a9;
	background-color: #f9f9f9;
	display: block;
	position: absolute;
	left: 680px;
	top: 15px;
	opacity: 0;
}
div#cont_con {
	position: relative;
	height: 60px;
	width: 690px;
	padding-top: 15px;
	margin: auto;
}
div#conteneur_presentation {
	position: relative;
	margin: auto;
	width: 910px;
	margin-top: 15%;
}
div#conteneur input.saisie {
	display: block;
	position: relative;
	margin-bottom: 27px;
}
input.erreur {
	border: 1px solid #cd5d5d !important;
}
input#inscription {
	opacity: 0;
	display: block;
	position: absolute;
}
input:focus {
	border: 1px solid #68a5cb !important;
}
span.typo {
	font-family: modernic;
}
a.supr_comment_moi {
	color: #a2a2a2 !important;
}
a.supr_comment_moi:hover {
	color: #cb6868 !important;
}
.texte_msg_droite {
    padding: 5px;
    position: relative !important;
    color: black !important;
    border: 1px solid #F1EFF0 !important;
    border: 1px solid #F1EFF0 !important;
    background: #F1EFF0 !important;
    width: auto !important;
    float: left !important;
    margin-left: 20px !important;
    text-align: center !important;
}
.date_texte_droite {
	text-align: left !important;
	left: 0px !important;
}
