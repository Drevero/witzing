/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "LICENSE.txt")
*/
function afficher_info_bulle(nom, stat)
{
	if(stat)
	{
		document.getElementById(nom).style.display='block';
	}
	else
	{
		document.getElementById(nom).style.display='none';
	}
}
function verif_inscr()
{
	var erreur_total=false;
	var liste_champ=['pseudo_inscr', 'mail_inscr', 'passe_inscr'];
	var longueur_liste=liste_champ.length;
	for(var i=0;i<longueur_liste;i++)
	{
		var objet_actuel=document.getElementById(liste_champ[i]);
		if(objet_actuel.value.length<=3)
		{
			erreur_total=true;
			objet_actuel.setAttribute('class', 'saisie erreur');
		}
		else
		{
			objet_actuel.setAttribute('class', 'saisie');
		}
	}
	var reg_email=new RegExp('[0-9a-z]@[0-9a-z]{2,190}[.]{1}[a-z]{2}', 'g');
	var email_inscr=document.getElementById(liste_champ[1]);
	if(reg_email.test(email_inscr.value))
	{
		email_inscr.setAttribute('class', 'saisie');
	}
	else
	{
		erreur_total=true;
		email_inscr.setAttribute('class', 'saisie erreur');
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
	if((document.getElementById(liste_champ[0]).value).lastIndexOf(' ')!='-1')
	{
		erreur_total=true;
		document.getElementById(liste_champ[0]).setAttribute('class', 'saisie erreur');
	}
	if(erreur_total)
	{
	}
	else
	{
		document.getElementById('inscr_form').submit();
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
			document.getElementById('avatar_apercu').style.border='0';
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
