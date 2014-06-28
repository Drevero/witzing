/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
var titre_fenetre=document.title;
function getXMLHttpRequest()
{
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject('Msxml2.XMLHTTP');
			} catch(e) {
				xhr = new ActiveXObject('Microsoft.XMLHTTP');
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert('Votre navigateur ne supporte pas l\'objet XMLHTTPRequest...');
		return null;
	}
	
	return xhr;
}
function changer_fond()
{
	document.getElementById('fichier_fond').click();
}
function visual_fond()
{
	lecteur_img=new FileReader();
	lecteur_img.onload=function(lectev) {
		document.getElementById('apercu_fond').src=lectev.target.result;
	};
	var fichier=document.getElementById('fichier_fond').files[0];
	if(fichier.type=='image/png' || fichier.type=='image/jpeg' || fichier.type=='image/gif' || fichier.type=='image/jpg')
	{
		if(fichier.size<1000000)
		{
			document.getElementById('fond_change').value='1';
			lecteur_img.readAsDataURL(fichier);
			document.getElementsByClassName('fond_fil_bt')[0].style.color='#68a5cb';
		}
		else
		{
			alert('Désolé, mais l\'image est trop volumineuse (>1mio)');
		}
	}
	else
	{
		alert('Désolé, mais votre type de format est non supporté (' + fichier.type + '), format supportés : png, jpeg, gif');
	}
}
function recup_nmb_co()
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			var ndom=xhr.responseXML;
			var balise=ndom.getElementsByTagName('membre').length;
			if(balise=='0')
			{
				document.getElementById('conteneur_mm_co').innerHTML='<p id="amis_connecte_titre">Aucun amis connecté</p>';
				document.getElementById('bt_amis_co').src='../data/style/led0.png';
			}
			else
			{
				document.getElementById('conteneur_mm_co').innerHTML='<p id="amis_connecte_titre">Mes amis connectés (' + balise + ')</p>';
				document.getElementById('bt_amis_co').src='../data/style/led1.png';
			}
			for(var i=0;i<balise;i++)
			{
				var div_mm=document.createElement('div');
				div_mm.setAttribute('class', 'amis_connecte');
				var p_div=document.createElement('p');
				var a_div=document.createElement('a');
				a_div.innerHTML=ndom.getElementsByTagName('membre')[i].getAttribute('pseudo');
				a_div.setAttribute('href', 'messages.php?id=' + ndom.getElementsByTagName('membre')[i].getAttribute('discution'));
				var img_div=document.createElement('img');
				var a_img=document.createElement('a');
				a_img.setAttribute('href', 'index.php?id=' + ndom.getElementsByTagName('membre')[i].getAttribute('discution'));
				a_img.setAttribute('class', 'a_img_div');
				img_div.src=ndom.getElementsByTagName('membre')[i].getAttribute('avatar');
				a_img.appendChild(img_div);
				p_div.appendChild(a_div);
				div_mm.appendChild(a_img);
				div_mm.appendChild(p_div);
				document.getElementById('conteneur_mm_co').appendChild(div_mm);
			}
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=nmb_mm_co', true);
	xhr.send(null);
	setTimeout('recup_nmb_co()', 60000);
}
function afficher_cacher_amis()
{
	var conteneur_mm_co=document.getElementById('conteneur_mm_co');
	var pastille_verte=document.getElementById('bt_amis_co');
	if(conteneur_mm_co.style.display=='block')
	{
		conteneur_mm_co.style.display='none';
		pastille_verte.style.left='0px';
	}
	else
	{
		conteneur_mm_co.style.display='block';
		pastille_verte.style.left='301px';
	}
}
function resp_page(url)
{
	window.location=url;
}
function recup_nmb_inscr()
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			var ndom=xhr.responseXML;
			var balise=ndom.getElementsByTagName('nombre')[0];
			document.getElementById('nmb_inscr').innerHTML=balise.getAttribute('inscrit');
			document.getElementById('nmb_co').innerHTML=balise.getAttribute('connecte');
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=nmb_inscr_co', true);
	xhr.send(null);
	setTimeout('recup_nmb_inscr()', 10000);
}
function lightbox(url, stat)
{
	if(stat)
	{
		document.getElementById('lightbox').style.display='block';
		document.getElementById('lightbox_img').src=url;
	}
	else
	{
		document.getElementById('lightbox').style.display='none';
		document.getElementById('lightbox_img').src='';
	}
}
function plus_moins_info(moi)
{
	if(document.getElementById('boite_plus_info_mm').style.display=='block')
	{
		document.getElementById('boite_plus_info_mm').style.display='none';
		document.getElementById('bt_plus_info_mm').innerHTML='Plus d\'informations +';
		if(moi)
		{
			document.getElementById('boite_plus_info_mm').style.marginBottom='15px';
			document.getElementById('bt_plus_info_mm').style.marginBottom='-70px';
		}
	}
	else
	{
		document.getElementById('boite_plus_info_mm').style.display='block';
		document.getElementById('bt_plus_info_mm').innerHTML='Moins d\'informations -';
		if(moi)
		{
			document.getElementById('boite_plus_info_mm').style.marginBottom='-70px';
			document.getElementById('bt_plus_info_mm').style.marginBottom='15px';
		}
	}
}
function repondre_membre(membre)
{
	document.getElementById('comment_input_text').value+='@' + membre + ' ';
}
function envois_message_salon(contenu)
{
	var cont_message=document.getElementById('cont_message_salon');
	if(contenu.length>0)
	{
		var xhr=getXMLHttpRequest();
		xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
				
		}
		};
		xhr.open('POST', '../data/xml_gen.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var contenuEncoded = encodeURIComponent(contenu);
		xhr.send('message_salon=' + contenuEncoded);
		cont_message.value='';
		cont_message.setAttribute('class', '');
	}
	else
	{
		cont_message.setAttribute('class', 'erreur');
	}
}
function message_salon_commun()
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			document.getElementById('conteneur_message_salon').innerHTML='';
			var ndom=xhr.responseXML;
			if(ndom.getElementsByTagName('message').length==0)
			{
				document.getElementById('conteneur_message_salon').innerHTML='<p class="no_message">Aucun message ...</p>';
			}
			var balise_message=ndom.getElementsByTagName('message').length;
			for(var i=balise_message;i>0;i--)
			{
				var e=(i-1);
				if(ndom.getElementsByTagName('message')[e].getAttribute('parlemoi')=='1')
				{
					document.getElementById('conteneur_message_salon').innerHTML+='<p class="texte_salon"><a href="index.php?id=' + ndom.getElementsByTagName('message')[e].getAttribute('id_auteur') + '" class="auteur_texte parle_moi">@' + ndom.getElementsByTagName('message')[e].getAttribute('pseudo') + '</a><span class="date_texte"> ' + ndom.getElementsByTagName('message')[e].getAttribute('date') + '</span><span class="corp_texte"> ' + ndom.getElementsByTagName('message')[e].getAttribute('contenu') + '</span></p>';
				}
				else
				{
					document.getElementById('conteneur_message_salon').innerHTML+='<p class="texte_salon"><a href="index.php?id=' + ndom.getElementsByTagName('message')[e].getAttribute('id_auteur') + '" class="auteur_texte">@' + ndom.getElementsByTagName('message')[e].getAttribute('pseudo') + '</a><span class="date_texte"> ' + ndom.getElementsByTagName('message')[e].getAttribute('date') + '</span><span class="corp_texte"> ' + ndom.getElementsByTagName('message')[e].getAttribute('contenu') + '</span></p>';
				}
			}
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=msg_salon_commun', true);
	xhr.send(null);
	setTimeout('message_salon_commun()', 2000);
}
function context_vive(nmb, etat)
{
	if(etat)
	{
		if(nmb!=4)
		{
			document.getElementsByClassName('context_glisse')[nmb].setAttribute('class', 'context_glisse select_glisse');
		}
		else
		{
			document.getElementsByClassName('context_glisse')[4].setAttribute('class', 'context_glisse select_glisse_dec');
		}
	}
	else
	{
		document.getElementsByClassName('context_glisse')[nmb].setAttribute('class', 'context_glisse');
	}
}
function stop_suggest()
{
	document.getElementById('suggest_membre').style.display='none';
}
function recherche_membre(valeur)
{
	var suggest_membre=document.getElementById('suggest_membre');
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			suggest_membre.innerHTML='';
			var ndom=xhr.responseXML;
			if(ndom.getElementsByTagName('membre').length>0)
			{
				suggest_membre.style.display='block';
				for(var i=0;i<ndom.getElementsByTagName('membre').length;i++)
				{
					suggest_membre.innerHTML+='<div class="membre_result_rech"><img src="' + ndom.getElementsByTagName('membre')[i].getAttribute('avatar') + '" alt="avatar"/><a href="index.php?id=' + ndom.getElementsByTagName('membre')[i].getAttribute('id_membre') + '"><p class="membre_pseudo">' + ndom.getElementsByTagName('membre')[i].getAttribute('pseudo') + '</p></a></div>';
				}
			}
			else
			{
				suggest_membre.style.display='none';
			}
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=recherche_membre&rech=' + valeur, true);
	xhr.send(null);
}
function message_salon(salon)
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			document.getElementById('conteneur_messages').innerHTML='';
			var ndom=xhr.responseXML;
			if(ndom.getElementsByTagName('message').length==0)
			{
				document.getElementById('conteneur_messages').innerHTML='<p class="no_message">Aucun message ...</p>';
			}
			document.getElementById('con_message').src='../data/style/led' + ndom.getElementsByTagName('connecte')[0].getAttribute('valeur') + '.png';
			if(ndom.getElementsByTagName('clavier')[0].getAttribute('valeur')=='1')
			{
				document.getElementById('texte_infos_msg').innerHTML=echape_html(ndom.getElementsByTagName('clavier')[0].getAttribute('pseudo')) + ' est au clavier ...';
			}
			else
			{
				if(ndom.getElementsByTagName('lu')[0].getAttribute('valeur')=='1')
				{
					document.getElementById('texte_infos_msg').innerHTML='Tous les messages ont été lus';
				}
				else
				{
					document.getElementById('texte_infos_msg').innerHTML='';
				}
			}
			var balise_message=ndom.getElementsByTagName('message').length;
			for(var i=balise_message;i>0;i--)
			{
				var e=(i-1);
				if(ndom.getElementsByTagName('message')[e].getAttribute('align')=='gauche')
				{
					document.getElementById('conteneur_messages').innerHTML+='<div class="cadre_gauche"><a href="index.php?id=' + ndom.getElementsByTagName('message')[e].getAttribute('id_auteur') + '"><img src="' + ndom.getElementsByTagName('message')[e].getAttribute('avatar') + '" alt="avatar" class="avat_msg"/></a><img src="../data/style/fleche_gauche.png" alt="fleche_gauche" class="fleche_gauche"/><p class="texte_msg"><span class="date_texte">' + ndom.getElementsByTagName('message')[e].getAttribute('date') + ' </span>' + ndom.getElementsByTagName('message')[e].getAttribute('contenu') + '</p></div>';
				}
				else
				{
					document.getElementById('conteneur_messages').innerHTML+='<div class="cadre_droite"><a href="index.php?id=' + ndom.getElementsByTagName('message')[e].getAttribute('id_auteur') + '"><img src="' + ndom.getElementsByTagName('message')[e].getAttribute('avatar') + '" alt="avatar" class="avat_msg_droite"/></a><img src="../data/style/fleche_droite.png" alt="fleche_droite" class="fleche_droite"/><p class="texte_msg_droite">' + ndom.getElementsByTagName('message')[e].getAttribute('contenu') + ' <span class="date_texte">' + ndom.getElementsByTagName('message')[e].getAttribute('date') + ' </span></p></div>';
				}
			}
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=msg_salon&salon_id=' + salon, true);
	xhr.send(null);
	setTimeout('message_salon(\'' + salon + '\')', 2000);
}
function verif_comment()
{
	if(document.getElementById('comment_input_text').value.length>0)
	{
		document.getElementById('form_comment').submit();
	}
	else
	{
		document.getElementById('comment_input_text').style.border='1px solid #cd5d5d';
	}
}
function verif_post()
{
	var erreur_total=false;
	if(document.getElementById('photo_change').value=='1')
	{
		document.getElementById('apercu_photo').src=document.getElementById('apercu_photo').src;
		if(document.getElementById('apercu_photo').complete)
		{
			document.getElementsByClassName('photo_post_bt')[0].style.border='';
		}
		else
		{
			document.getElementsByClassName('photo_post_bt')[0].style.border='1px solid red';
			erreur_total=true;
		}
	}
	if(document.getElementById('post_text').value.length>0)
	{
		if(!erreur_total)
		{
			document.getElementsByClassName('publier_post')[0].style.backgroundImage='url(\'../data/style/loader.gif\')';
			document.getElementsByClassName('publier_post')[0].value='';
			document.getElementById('post_form').submit();
		}
	}
	else
	{
		document.getElementById('post_text').style.border='1px solid #cd5d5d';
	}
}
function notif(nom)
{
	document.getElementById('fleche').style.opacity='1';
	document.getElementById('cont_inf').style.opacity='1';
	document.getElementById('cont_inf').style.minHeight='auto';
	document.getElementById('cont_inf').style.width='195px';
	document.getElementById('notif_msg_conteneur').style.display='none';
	document.getElementById('notif_amis_conteneur').style.display='none';
	document.getElementById('notif_plan_conteneur').style.display='none';
	if(nom=='1')
	{
		document.getElementById('notif_plan_conteneur').style.display='block';
		document.getElementById('fleche').style.marginLeft='12px';
	}
	if(nom=='2')
	{
		document.getElementById('notif_amis_conteneur').style.display='block';
		document.getElementById('fleche').style.marginLeft='58px';
	}
	if(nom=='3')
	{
		document.getElementById('notif_msg_conteneur').style.display='block';
		document.getElementById('fleche').style.marginLeft='105px';
	}
}
function switch_dis(nmb, etat)
{
	if(etat)
	{
		document.getElementById('etat_dm' + nmb).style.display='block';
	}
	else
	{
		document.getElementById('etat_dm' + nmb).style.display='none';
	}
}
function supr_notif(id_notif)
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
		}
	};
	xhr.open('GET', 'index.php?notif_lus=' + id_notif, true);
	xhr.send(null);
	cherche_notif(true);
}
function vider_notif()
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=vider_notif', true);
	xhr.send(null);
	cherche_notif(true);
}
function vider_message()
{
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=vider_message', true);
	xhr.send(null);
	cherche_notif(true);
}
function cherche_notif(valeur)
{
	var notif_msg_conteneur=document.getElementById('notif_msg_conteneur');
	var notif_msg=document.getElementById('notif_msg');
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			notif_msg_conteneur.innerHTML='';
			var ndom=xhr.responseXML;
			var nmb_notif=ndom.getElementsByTagName('nombremp')[0].getAttribute('valeur');
			if(nmb_notif>0)
			{
				nombre_notif_msg=true;
				notif_msg.style.display='block';
				notif_msg.innerHTML=nmb_notif;
			}
			else
			{
				nombre_notif_msg=false;
				notif_msg.style.display='none';
			}
			if(ndom.getElementsByTagName('message').length==0)
			{
				notif_msg_conteneur.innerHTML='<p class="no_demande">Aucun nouveau message</p>';
			}
			else
			{
				for(var i=0;i<ndom.getElementsByTagName('message').length;i++)
				{
					notif_msg_conteneur.innerHTML+='<div class="demande_amis_p" style="background: #e8e8e8;"><img src="' + ndom.getElementsByTagName('message')[i].getAttribute('avatar') + '" alt="avatar"/><a href="' + ndom.getElementsByTagName('message')[i].getAttribute('lien') + '"><p class="notif_texte">"' + echape_html(ndom.getElementsByTagName('message')[i].getAttribute('contenu')) + '"</p></a></div>';
				}
				notif_msg_conteneur.innerHTML+='<div class="demande_amis_p poubelle_notif_con" style="background: #e8e8e8;"><p class="poubelle_notif" onclick="vider_message();">I</p></div>';
			}
			document.getElementById('notif_plan_conteneur').innerHTML='';
			var nmb_notif=ndom.getElementsByTagName('nombrenot')[0].getAttribute('valeur');
			if(nmb_notif>0)
			{
				document.getElementById('notif_plan').style.display='block';
				document.getElementById('notif_plan').innerHTML=nmb_notif;
			}
			else
			{
				nombre_notif=false;
				document.getElementById('notif_plan').style.display='none';
			}
			if(ndom.getElementsByTagName('notification').length==0)
			{
				nombre_notif=false;
				document.getElementById('notif_plan_conteneur').innerHTML='<p class="no_demande">Aucune Notification</p>';
			}
			else
			{
				nombre_notif=true;
				for(var i=0;i<ndom.getElementsByTagName('notification').length;i++)
				{
					document.getElementById('notif_plan_conteneur').innerHTML+='<div class="demande_amis_p" style="background: #e8e8e8;"><img src="' + ndom.getElementsByTagName('notification')[i].getAttribute('avatar') + '" alt="avatar"/><p class="supr_notif_bt" onclick="supr_notif(' + ndom.getElementsByTagName('notification')[i].getAttribute('id') + ');">x</p><a href="' + ndom.getElementsByTagName('notification')[i].getAttribute('lien') + '"><p class="notif_texte">' + echape_html(ndom.getElementsByTagName('notification')[i].getAttribute('contenu')) + '</p></a></div>';
				}
				document.getElementById('notif_plan_conteneur').innerHTML+='<div class="demande_amis_p poubelle_notif_con" style="background: #e8e8e8;"><p class="poubelle_notif" onclick="vider_notif();">I</p></div>';
			}
			document.getElementById('notif_amis_conteneur').innerHTML='';
			if(ndom.getElementsByTagName('nombredmd')[0].getAttribute('valeur')>0)
			{
				nombre_demande_amis=true;
				document.getElementById('notif_amis').style.display='block';
				document.getElementById('notif_amis').innerHTML=ndom.getElementsByTagName('nombredmd')[0].getAttribute('valeur');
			}
			else
			{
				nombre_demande_amis=false;
				document.getElementById('notif_amis_conteneur').innerHTML+='<p class="no_demande">Aucune demande</p>';
				document.getElementById('notif_amis').style.display='none';
			}
			var nmb_amisd=ndom.getElementsByTagName('demande').length;
			for(var i=0;i<nmb_amisd;i++)
			{
				if(nmb_amisd==(i+1))
				{
					document.getElementById('notif_amis_conteneur').innerHTML+='<div class="demande_amis_p" style="border-bottom: 0px;" onmouseover="switch_dis(\'' + i + '\', true);" onmouseout="switch_dis(\'' + i + '\', false);"><img src="' + ndom.getElementsByTagName('demande')[i].getAttribute('avatar') + '" alt="avatar"/><p>' + echape_html(ndom.getElementsByTagName('demande')[i].getAttribute('pseudo')) + '</p><span class="typo refus_accept" id="etat_dm' + i +'"><a href="#" onclick="amis_conf(\'' + ndom.getElementsByTagName('demande')[i].getAttribute('id') + '\', false);" class="refus" title="Refuser la demande en amis de ' + echape_html(ndom.getElementsByTagName('demande')[i].getAttribute('pseudo')) + '">X</a> <a href="#" onclick="amis_conf(\'' + ndom.getElementsByTagName('demande')[i].getAttribute('id') + '\', true);" class="accept" title="Accepter la demande en amis de ' + echape_html(ndom.getElementsByTagName('demande')[i].getAttribute('pseudo')) + '">%</a></span></div>';
				}
				else
				{
					document.getElementById('notif_amis_conteneur').innerHTML+='<div class="demande_amis_p" onmouseover="switch_dis(\'' + i + '\', true);" onmouseout="switch_dis(\'' + i + '\', false);"><img src="' + ndom.getElementsByTagName('demande')[i].getAttribute('avatar') + '" alt="avatar"/><p>' + echape_html(ndom.getElementsByTagName('demande')[i].getAttribute('pseudo')) + '</p><span class="typo refus_accept" id="etat_dm' + i +'"><a href="#" onclick="amis_conf(\'' + ndom.getElementsByTagName('demande')[i].getAttribute('id') + '\', false);" class="refus" title="Refuser la demande en amis de ' + echape_html(ndom.getElementsByTagName('demande')[i].getAttribute('pseudo')) + '">X</a> <a href="#" onclick="amis_conf(\'' + ndom.getElementsByTagName('demande')[i].getAttribute('id') + '\', true);" class="accept" title="Accepter la demande en amis de ' + echape_html(ndom.getElementsByTagName('demande')[i].getAttribute('pseudo')) + '">%</a></span></div>';
				}
			}
		}
		if(nombre_notif || nombre_demande_amis || nombre_notif_msg)
		{
			document.title='! ' + titre_fenetre + ' !';
		}
		else
		{
			document.title=titre_fenetre;
		}
	};
	xhr.open('GET', '../data/xml_gen.php?req=notif', true);
	xhr.send(null);
	if(!valeur)
	{
		setTimeout('cherche_notif()', 10000);
	}
}
function amis_conf(ida, ref)
{
	if(ref)
	{
		var xhr=new XMLHttpRequest();
		xhr.open('GET', 'index.php?amis=' + ida + '&etat=accepter', true);
		xhr.send(null);
	}
	else
	{
		var xhr=new XMLHttpRequest();
		xhr.open('GET', 'index.php?amis=' + ida + '&etat=refus', true);
		xhr.send(null);
	}
}
function envois_mp(salon, contenu)
{
	var cont_message=document.getElementById('cont_message');
	if(contenu.length>0)
	{
		var xhr=getXMLHttpRequest();
		xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
				
		}
		};
		xhr.open('POST', '../data/xml_gen.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var contenuEncoded = encodeURIComponent(contenu);
		xhr.send('message=' + contenuEncoded + '&salon=' + salon);
		cont_message.value='';
		cont_message.setAttribute('class', '');
	}
	else
	{
		cont_message.setAttribute('class', 'erreur');
	}
}
function echape_html(texte)
{
	var texte_traiter='';
	if(texte.lastIndexOf('<')!='-1')
	{
		for(var i=0;i<texte.length;i+=1)
		{
			if(texte.charAt(i)=='<')
			{
				texte_traiter+='&lt;';
			}
			else
			{
				texte_traiter+=texte.charAt(i);
			}
		}
	}
	if(texte.lastIndexOf('>')!='-1')
	{
		for(var i=0;i<texte.length;i+=1)
		{
			if(texte.charAt(i)=='>')
			{
				texte_traiter+='&gt;';
			}
			else
			{
				texte_traiter+=texte.charAt(i);
			}
		}
	}
	if(texte.lastIndexOf('>')=='-1' && texte.lastIndexOf('<')=='-1')
	{
		texte_traiter=texte;
	}
	return texte_traiter;
}
function msg_lu(salon)
{
	var xhr=new XMLHttpRequest();
	xhr.open('GET', '../data/xml_gen.php?req=msg_lu&salon_id=' + salon, true);
	xhr.send(null);
}
function verif_clavier(salon)
{
	var cont_message=document.getElementById('cont_message');
	if(cont_message.value.length==1)
	{
		var xhr=new XMLHttpRequest();
		xhr.open('GET', '../data/xml_gen.php?req=clavier_true&salon_id=' + salon, true);
		xhr.send(null);
	}
	if(cont_message.value.length==0)
	{
		var xhr=new XMLHttpRequest();
		xhr.open('GET', '../data/xml_gen.php?req=clavier_false&salon_id=' + salon, true);
		xhr.send(null);
	}
}
function changer_avatar()
{
	document.getElementById('fichier_avat').click();
}
function visual_avatar()
{
	lecteur_img=new FileReader();
	lecteur_img.onload=function(lectev) {
		document.getElementById('avatar_apercu').src=lectev.target.result;
	};
	var fichier=document.getElementById('fichier_avat').files[0];
	if(fichier.type=='image/png' || fichier.type=='image/jpeg' || fichier.type=='image/gif' || fichier.type=='image/jpg')
	{
		if(fichier.size<2000000)
		{
			lecteur_img.readAsDataURL(fichier);
			document.getElementById('avatar_change').value='1';
		}
		else
		{
			alert('Désolé, mais l\'image est trop volumineuse (>2mio)');
		}
	}
	else
	{
		alert('Désolé, mais votre type de format est non supporté (' + fichier.type + '), format supportés : png, jpeg, gif');
	}
}
function verif_modif()
{
	var erreur_total=false;
	var liste_champ=['pseudo_mod', 'email_mod', 'mdp1_mod', 'mdp2_mod'];
	for(var i=0;i<liste_champ.length;i++)
	{
		var objet_actuel=document.getElementById(liste_champ[i]);
		if(objet_actuel.value.length<=3)
		{
			erreur_total=true;
			objet_actuel.setAttribute('class', 'erreur');
		}
		else
		{
			objet_actuel.setAttribute('class', '');
		}
	}
	if((document.getElementById(liste_champ[0]).value).lastIndexOf(' ')!='-1')
	{
		erreur_total=true;
		document.getElementById(liste_champ[0]).setAttribute('class', 'erreur');
	}
	var reg_chevron=new RegExp('>', 'g');
	if(reg_chevron.test(document.getElementById(liste_champ[0]).value))
	{
		erreur_total=true;
		document.getElementById(liste_champ[0]).setAttribute('class', 'saisie erreur');
	}
	else
	{
		document.getElementById(liste_champ[0]).setAttribute('class', 'saisie');
	}
	if(document.getElementById(liste_champ[2]).value!=document.getElementById(liste_champ[3]).value)
	{
		erreur_total=true;
		document.getElementById(liste_champ[3]).setAttribute('class', 'erreur');
	}
	else
	{
		document.getElementById(liste_champ[3]).setAttribute('class', '');
	}
	var reg_email=new RegExp('[0-9a-z]@[0-9a-z]{2,190}[.]{1}[a-z]{2}', 'g');
	var email_mod=document.getElementById(liste_champ[1]);
	if(reg_email.test(email_mod.value))
	{
		email_mod.setAttribute('class', '');
	}
	else
	{
		erreur_total=true;
		email_mod.setAttribute('class', 'erreur');
	}
	document.getElementById('avatar_apercu').src=document.getElementById('avatar_apercu').src;
	if(document.getElementById('avatar_apercu').complete)
	{
		document.getElementById('avatar_apercu').style.border='';
	}
	else
	{
		document.getElementById('avatar_apercu').style.border='1px solid red';
		erreur_total=true;
	}
	if(erreur_total)
	{
	}
	else
	{
		document.getElementById('sauvegarder_modif_compte').setAttribute('onclick', '');
		document.getElementById('sauvegarder_modif_compte').value='';
		document.getElementById('sauvegarder_modif_compte').style.backgroundImage='url(\'../data/style/loader.gif\')';
		document.getElementById('form_mod').submit();
	}
}
function changer_photo_statut()
{
	document.getElementById('fichier_photo').click();
}
function visual_photo_statut()
{
	lecteur_img=new FileReader();
	lecteur_img.onload=function(lectev) {
		document.getElementById('apercu_photo').src=lectev.target.result;
	};
	var fichier=document.getElementById('fichier_photo').files[0];
	if(fichier.type=='image/png' || fichier.type=='image/jpeg' || fichier.type=='image/gif' || fichier.type=='image/jpg')
	{
		if(fichier.size<2000000)
		{
			document.getElementById('photo_change').value='1';
			lecteur_img.readAsDataURL(fichier);
			document.getElementsByClassName('photo_post_bt')[0].style.color='#68a5cb';
		}
		else
		{
			alert('Désolé, mais l\'image est trop volumineuse (>2mio)');
		}
	}
	else
	{
		alert('Désolé, mais votre type de format est non supporté (' + fichier.type + '), format supportés : png, jpeg, gif');
	}
}
if(~navigator.userAgent.indexOf('Windows'))
{
	if(document.getElementsByClassName('notif')[0])
	{
		document.getElementsByClassName('notif')[0].style.top='1px';
		document.getElementsByClassName('notif')[1].style.top='1px';
		document.getElementsByClassName('notif')[2].style.top='1px';
	}
}
cherche_notif();
recup_nmb_co();
