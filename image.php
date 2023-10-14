<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
$imagesJson = importJSON('./data/images.json');
?>


<?php
$isError=null;

if(!isset($_GET['photoid'])) $isError='the photo id is invalid';

$selectedImage=null;
foreach($imagesJson as $image) if ($image['id']==$_GET['photoid']) $selectedImage=$image;

if($selectedImage===null) $isError='photo couldn\'t be found';

if($isError===null)
{	echo echoHeader('Selected Photo: ' . $selectedImage['name']);
	$isAuthenticatedUser=false;
	if(isset($_SESSION['user_id']))
		if($_SESSION['user_id']==$selectedImage['owner'])
			$isAuthenticatedUser=true;
	echo generateAlbumSquare($selectedImage,'.',false,$isAuthenticatedUser);
}
else echo echoHeader($isError);
?>


<?= echoFooter() ?>