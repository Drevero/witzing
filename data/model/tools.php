<?php
/* 
tools.php contient toutes les fonctions qui consiste aux post-traitement de certaines données 
*/
function coupeur($chaine)
{
	if(strlen($chaine)>50)
	{
		$chaine_decomp=str_split($chaine);
		$prochaine_chaine='';
		for($i=0;$i<30;$i++)
		{
			$prochaine_chaine.=$chaine_decomp[$i];
		}
		return $prochaine_chaine . '...';
	}
	else
	{
		return $chaine;
	}
}
function markdown($texte)
{
	return $texte;
}
function hashtageur($hashtag)
{
	$regex_hashtag='A-Z0-9éèàêëâä\-_à€';
	$hashtag=preg_replace('#\#([' . $regex_hashtag . ']+)#i', '<a href="recherche.php?recherche_cle=$1&amp;interet" title="$1">$0</a>', $hashtag);
	return $hashtag;
}
function citeur_mm($cite)
{
	$regex_hashtag='A-Z0-9éèàêëâä\-_à€';
	$cite=preg_replace('#\@([' . $regex_hashtag . ']+)#i', '<a href="index.php?nom=$1" title="$1">$0</a>', $cite);
	return $cite;
}
function linkeur($lien)
{
	if(preg_match('#(png|PNG|gif|gif|JPG|jpg|jpeg|JPEG)#isU', $lien))
	{
		$lien=preg_replace('#(http|https)://(.+)$#isU', '<a href="javascript:;" onclick="lightbox(\'$0\', true);"><img src="$0" class="mini_img" title="$0"/></a>', $lien);
	}
	else
	{
		$lien=preg_replace('#(http|ftp|steam|https)://([A-Z0-9_-]+)(\.[a-z0-9]+){1,2}/?([A-Z0-9-/_\?=&;!\.]+)#i', '<a href="$0" title="$0">$0</a>', $lien);
	}
	return $lien;
}
function emoticons($texte)
{
	$liste_emoticons=Array('smile.png', 'sad.png', 'shock.png', 'embarrassed.png', 'good.png', 'laugh.png', 'love.png', 'mail.png', 'meeting.png', 'neutral.png', 'poop.png', 'present.png', 'quiet.png', 'rotfl.png', 'sick.png', 'sleepy.png', 'smile-big.png', 'sweat.png', 'tongue.png', 'victory.png', 'weep.png', 'wink.png', 'sun.png', 'question.png', 'bad.png', 'msn.png', 'car.png', 'knife.png', 'dog.png', 'beat-up.png', 'search.png', 'silly.png', 'shout.png', 'confused.png', 'party.png', 'worship.png', 'mad-tongue.png', 'musical-note.png', 'bashful.png', 'cat.png', 'sheep.png', 'msn-busy.png', 'star.png', 'angry.png', 'rose.png', 'desire.png', 'rain.png', 'beauty.png', 'goat.png', 'ghost.png', 'soldier.png', 'bomb.png', 'moon.png', 'doh.png', 'cloudy.png', 'struggle.png', 'go-away.png', 'island.png', 'devil.png', 'snail.png', 'rainbow.png', 'plate.png', 'in-love.png', 'call-me.png', 'eat.png', 'beer.png', 'boy.png', 'can.png', 'excruciating.png', 'jump.png', 'pizza.png', 'cake.png', 'curl-lip.png', 'drool.png', 'sigarette.png', 'hammer.png', 'pissed-off.png', 'eyeroll.png', 'secret.png', 'handcuffs.png', 'mean.png', 'monkey.png', 'vampire.png', 'terror.png', 'arrogant.png', 'camera.png', 'umbrella.png', 'skywalker.png', 'nailbiting.png', 'clover.png', 'bye.png', 'tv.png', 'disdain.png', 'kiss.png', 'cow.png', 'msn-away.png', 'lying.png', 'phone.png', 'airplane.png', 'glasses-nerdy.png', 'hug-left.png', 'waiting.png', 'hug-right.png', 'angel.png', 'act-up.png', 'clock.png', 'yin-yang.png', 'bowl.png', 'lashes.png', 'foot-in-mouth.png', 'girl.png', 'dance.png', 'doctor.png', 'clown.png', 'tremble.png', 'giggle.png', 'glasses-cool.png', 'chicken.png', 'sarcastic.png', 'peace.png', 'hypnotized.png', 'moneymouth.png', 'yawn.png', 'liquor.png', 'film.png', 'snowman.png', 'starving.png', 'drink.png', 'clap.png', 'snicker.png', 'skeleton.png', 'curse.png', 'msn_online.png', 'handshake.png', 'coffee.png', 'qq.png', 'lamp.png', 'blowkiss.png', 'rose-dead.png', 'soccerball.png', 'thunder.png', 'hungry.png', 'cowboy.png', 'brb.png', 'pray.png', 'disapointed.png', 'mobile.png', 'coins.png', 'shut-mouth.png', 'highfive.png', 'pill.png', 'alien.png', 'freaked-out.png', 'wilt.png', 'fingers-crossed.png', 'computer.png', 'console.png', 'smirk.png', 'pig.png', 'teeth.png', 'pumpkin.png', 'turtle.png', 'watermelon.png', 'cute.png', 'dazed.png', 'flag.png');
	$texte_emo=Array(':\)', ':\(', ':O', ':X', '\(y\)', 'xD', '&lt;3', ':mail:', ':meeting:', ':/ ', ':caca:', ':cadeau:', ':chut:', 'x\'D', ':malade:', ':dormir:', ':D', '--\'', ':P', '\\\o/', ':\'\(', ';\)', ':soleil:', ':hein:', '\(n\)', '\[\[msn\]\]', '\[\[voiture\]\]', '\[\[kanife\]\]', '\[\[chien\]\]', '\[\[ouch\]\]', '\[\[loupe\]\]', '\[\[ailleurs\]\]', '\[\[cri\]\]', '\[\[confus\]\]', '\[\[fete\]\]', '\[\[exercice\]\]', '\[\[moquerie\]\]', '\[\[musique\]\]', '\[\[repos\]\]', '\[\[chat\]\]', '\[\[chevre\]\]', '\[\[msnoccupe\]\]', '\[\[etoile\]\]', '\[\[enerve\]\]', '\[\[rose\]\]', '\*\.\*', '\[\[pluie\]\]', '\[\[beaute\]\]', '\[\[chevre2\]\]', '\[\[fantome\]\]', '\[\[soldat\]\]', '\[\[bombe\]\]', '\[\[lune\]\]', '\[\[doh\]\]', '\[\[nuageux\]\]', '\[\[pensif\]\]', '\[\[jereviens\]\]', '\[\[ile\]\]', '\[\[diable\]\]', '\[\[escargot\]\]', '\[\[arcenciel\]\]', '\[\[couvert\]\]', '\[\[coupdefoudre\]\]', '\[\[appellemoi\]\]', '\[\[manger\]\]', '\[\[biere\]\]', '\[\[homme\]\]', '\[\[canette\]\]', 'D:', '\[\[saut\]\]', '\[\[pizza\]\]', '\[\[gateau\]\]', '\[\[fausettes\]\]', '\[\[bave\]\]', '\[\[cigarette\]\]', '\[\[marteau\]\]', '\[\[nerf\]\]', '\[\[eyeroll\]\]', '\[\[secret\]\]', '\[\[menottes\]\]', '\[\[determine\]\]', '\[\[singe\]\]', '\[\[vampire\]\]', '\[\[terroriste\]\]', '\[\[arrogant\]\]', '\[\[camera\]\]', '\[\[parapluie\]\]', '\[\[pilote\]\]', '\[\[stress\]\]', '\[\[trefle\]\]', '\[\[bye\]\]', '\[\[tv\]\]', '\[\[moqueur\]\]', '\[\[bisous\]\]', '\[\[vache\]\]', '\[\[msnreviens\]\]', '\[\[menteur\]\]', '\[\[telephone\]\]', '\[\[avions\]\]', '\[\[intellectuel\]\]', '\[\[gauche\]\]', '\[\[patient\]\]', '\[\[droite\]\]', '\[\[ange\]\]', ':hap:', '\[\[heure\]\]', '\[\[yinyang\]\]', '\[\[riz\]\]', '\[\[cils\]\]', '\[\[piedsurbouche\]\]', '\[\[femme\]\]', '\[\[danse\]\]', '\[\[docteur\]\]', '\[\[clown\]\]', '\[\[tremble\]\]', '\[\[hihi\]\]', '\[\[cool\]\]', '\[\[poulet\]\]', '\[\[sarcastic\]\]', '\[\[paix\]\]', '\[\[hypnose\]\]', '\[\[argent\]\]', '\[\[baille\]\]', '\[\[liqueur\]\]', '\[\[film\]\]', '\[\[bonhommeneige\]\]', '\[\[faim\]\]', '\[\[boire\]\]', '\[\[applaudir\]\]', '\[\[clin\]\]', '\[\[squelette\]\]', '\[\[enerveplus\]\]', '\[\[msnenligne\]\]', '\[\[tchek\]\]', '\[\[cafe\]\]', '\[\[pinguin\]\]', '\[\[lampe\]\]', '\[\[douxbaiser\]\]', '\[\[rosemorte\]\]', '\[\[foot\]\]', '\[\[orage\]\]', '\[\[enerve3\]\]', '\[\[cowboy\]\]', '\[\[brb\]\]', '\[\[prier\]\]', '\[\[malenpoint\]\]', '\[\[mobile\]\]', '\[\[coints\]\]', '\[\[shadup\]\]', '\[\[tape5\]\]', '\[\[pillule\]\]', '\[\[alien\]\]', '\[\[enerve4\]\]', '\[\[timide\]\]', '\[\[croise\]\]', '\[\[ordinateur\]\]', '\[\[console\]\]', '\[\[smirk\]\]', '\[\[cochon\]\]', '\[\[dents\]\]', '\[\[halloween\]\]', '\[\[tortue\]\]', '\[\[melons\]\]', '\[\[meugnon\]\]', '\[\[dazed\]\]', '\[\[usa\]\]');
	for($i=0;$i<count($texte_emo);$i++)
	{
		$texte=preg_replace('#' . $texte_emo[$i] . '#isU', '<img src="data/img/emoticons/' . $liste_emoticons[$i] . '" class="emoticons"/>', $texte);
	}
	return $texte;
}
function dateur($matches)
{
	$date_attr=false;
	if($matches[3]==date('d') && $matches[2]==date('m') && $matches[1]=date('Y'))
	{
		if($matches[4]==date('H') && $matches[5]!=date('i'))
		{
			if((date('i')-$matches[5])!=1)
			{
				return 'il y a ' . (date('i')-$matches[5]) . ' minutes';
			}
			else
			{
				return 'il y a 1 minute';
			}
		}
		else
		{
			if($matches[4]==date('H') && $matches[5]==date('i'))
			{
				return 'maintenant';
			}
			else
			{
				return 'aujourd\'hui à ' . $matches[4] . 'h' . $matches[5] . '';
			}
		}
		$date_attr=true;
	}
	if($matches[3]==(date('d')-1) && $matches[2]==date('m') && $matches[1]=date('Y'))
	{
		return 'hier à ' . $matches[4] . 'h' . $matches[5] . '';
		$date_attr=true;
	}
	if($matches[3]==(date('d')-2) && $matches[2]==date('m') && $matches[1]=date('Y'))
	{
		return 'avant-hier à ' . $matches[4] . 'h' . $matches[5] . '';
		$date_attr=true;
	}
	else
	{
		if($date_attr)
		{
		}
		else
		{
			return 'le ' . $matches[3] . '/' . $matches[2] . '/' . $matches[1] . ' à ' . $matches[4] . 'h' . $matches[5] . '';
		}
	}
}
function embed($chaine)
{
	$chaine=preg_replace('#(https|http)://www\.youtube\.com/watch\?v=(.+)#is', '<br /><iframe width="560" height="315" src="//www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe>', $chaine);
	$chaine=preg_replace('#(http|https)://www\.dailymotion\.com/video/(.+)#is', '<br /><iframe frameborder="0" width="480" height="270" src="//www.dailymotion.com/embed/video/$2" allowfullscreen></iframe>', $chaine);
	$chaine=preg_replace('#(http|https)://vimeo\.com/(.+)#is', '<br /><iframe src="//player.vimeo.com/video/$2" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>', $chaine);
	$chaine=preg_replace('#(https|http)://soundcloud.com/(.+)#is', '<br /><iframe src="//soundcloud.com/$2" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>', $chaine);
	return $chaine;
}
function couper($chaine, $longueur)
{
	if(strlen($chaine)>$longueur)
	{
		return substr($chaine, 0, $longueur) . ' ...';
	}
	else
	{
		return $chaine;
	}
}
function photo_statut($chaine)
{
	$chainetest=preg_replace('#\|~p\/statutp\/(.+)\.(.+)~\|#isU', '|~p/statutp/$1_mini.$2~|', $chaine);
	$fichier=explode('|~', $chainetest);
	if(!empty($fichier[1]))
	{
		$taille=strlen($fichier[1])-2;
		$fichierfin=substr($fichier[1], 0, $taille);
		if(file_exists($fichierfin))
		{
			$chaine=preg_replace('#\|~p\/statutp\/(.+)\.(.+)~\|#isU', '<a href="javascript:;" onclick="lightbox(\'p/statutp/$1.$2\', true);" title="Photo"><img src="p/statutp/$1_mini.$2" class="photo_statut"/></a>', $chaine);
		}
		else
		{
			$chaine=preg_replace('#\|~p\/statutp\/(.+)\.(.+)~\|#isU', '<a href="javascript:;" onclick="lightbox(\'p/statutp/$1.$2\', true);" title="Photo"><img src="p/statutp/$1.$2" class="photo_statut"/></a>', $chaine);
		}
	}
	else
	{
		$chaine=preg_replace('#\|~p\/statutp\/(.+)\.(.+)~\|#isU', '<a href="javascript:;" onclick="lightbox(\'p/statutp/$1.$2\', true);" title="Photo"><img src="p/statutp/$1_mini.$2" class="photo_statut"/></a>', $chaine);
	}
	return $chaine;
}
function photo_statut_desactiv($chaine)
{
	$chaine=preg_replace('#\|~(.+)~\|#isU', '[image]', $chaine);
	return $chaine;
}
?>
