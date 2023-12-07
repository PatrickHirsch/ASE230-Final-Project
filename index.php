<title>MyPhotoVault</title>
<?php
//Not sure what the purpose of this page is as users.php handles what I would believe this page should handle
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

//	echo '<!--';
//	var_dump ($_SESSION);
//	echo '-->';
displaySessionMessage();
processLogout();

if(isset($_SESSION['user_id']))
{	$thisUser=getUserObject($_SESSION['user_id']);
	$welcomeMessage='Welcome, '.$thisUser['name'].'!';
	$homepageButtons='<br><a href="user.php" class="btn btn-primary btn-rounded btn-lg mt-4">See my photos</a> <a href="upload.php" class="btn btn-outline-primary btn-rounded btn-lg mt-4 text-white">Upload new photo</a>';

}
else
{	$welcomeMessage='Welcome to MyPhotoVault!';
	$homepageButtons='<br><a href="login.php" class="btn btn-primary btn-rounded btn-lg mt-4">Login</a> <a href="signup.php" class="btn btn-outline-primary btn-rounded btn-lg mt-4 text-white">Signup</a>';
}
?>
<?= echoHeader($welcomeMessage,$homepageButtons) ?>
		
<?= generateAlbum() ?>
		
<?= echoFooter() ?>
		
<?php

?>
