<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
require_once('db/db.php');
?>


<?php



$isError=null;

if(!isset($_GET['photoid']))
{	$isError='the photo id is invalid';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) $isError='photo couldn\'t be found';
}


if($isError===null)
{	echo echoHeader('Selected Photo: ' . $selectedImage['name']);

	$isAuthenticatedUser=false;
	if(isset($_SESSION['user_id']))
		if($_SESSION['user_id']==$selectedImage['owner_id'])
			$isAuthenticatedUser=true;
	echo generateAlbumSquare($pdo,$selectedImage,'.',false,$isAuthenticatedUser);
}
else
{	echo echoHeader($isError);;
}
?>


<?= echoFooter() ?>