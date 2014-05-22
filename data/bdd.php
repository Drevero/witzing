<?php
/*
Witzing Copyright (C) 2014 Rémi Duplé sous les termes de la license GNU GPL version 3 (voir le fichier "licence.txt")
*/
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=', '', '');
	$bdd->exec('SET CHARACTER SET utf8');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
function redimmension_image($sourceimg, $taillex, $tailley, $destinationimg, $formatimg)
{
	if($formatimg!='gif' && $formatimg!='GIF')
	{
		$destination=imagecreatetruecolor($taillex, $tailley);
		if($formatimg=='jpg' || $formatimg=='jpeg' || $formatimg=='JPG' || $formatimg=='JPEG')
		{
			$source=imagecreatefromjpeg($sourceimg);
		}
		else
		{
			$source=imagecreatefrompng($sourceimg);
			$blanc=imagecolorallocate($destination, 255, 128, 0);
			imagealphablending($destination, false);
			imagesavealpha($destination, true);
		}
		$largeursource=imagesx($source);
		$hauteursource=imagesy($source);
		$largeurdestination=imagesx($destination);
		$hauteurdestination=imagesy($destination);
		imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeurdestination, $hauteurdestination, $largeursource, $hauteursource);
		if($formatimg=='jpg' || $formatimg=='jpeg' || $formatimg=='JPG' || $formatimg=='JPEG')
		{
			imagejpeg($destination, $destinationimg);
		}
		else
		{
			imagepng($destination, $destinationimg);
		}
	}
}
?>
