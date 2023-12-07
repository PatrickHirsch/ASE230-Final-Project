<?php
<<<<<<< HEAD
//This page displays a users image with the name of the image and the image description.
require_once('./lib/functions.php');
require_once('./header.php');
$imagesJson = importJSON('./data/images.json');

if (!isset($_GET['photoid'])) {
    echo 'the photo id is invalid';
    die();
}

$selectedImage = null;

foreach ($imagesJson as $image) {
    if ($image['id'] == $_GET['photoid']) {
        $selectedImage = $image;
    }
}

if ($selectedImage === null) {
    echo 'photo couldn\'t be found';
    die();
}

?>

<?= echoHeader('Selected Photo: ' . $selectedImage['name']) ?>

<?= generateAlbumSquare($selectedImage, '.', false) ?>
    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
        <div class="text-center">
            <a class="btn btn-outline-dark mt-auto"
               href="<?= 'editImage.php?photoid=' . $_GET['photoid'] ?>">
            Edit/Delete image
            </a>
        </div>
    </div>
=======
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

>>>>>>> 2c4588fa305e3873098c9468183810f6ddc8d011

<?= echoFooter() ?>