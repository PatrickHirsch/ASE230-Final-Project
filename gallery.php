<title>MyPhotoVault</title>
<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once './db/db.php';


if (!isset($_GET['gallery_id'])) {
    header('Location: index.php');
}

$gallery = getGallery($pdo, $_GET['gallery_id']);

if(isset($_SESSION['user_id']))
{	if(!canViewGallery($pdo,$_GET['gallery_id'],$_SESSION['user_id'])) header('Location: index.php');
}
else if(!canViewGallery($pdo,$_GET['gallery_id'],-1)) header('Location: index.php');

?>
<?= echoHeader($gallery['name'], $gallery['description']) ?>

<?=  generateGallery($pdo, $_GET['gallery_id']) ?>


<?= echoFooter() ?>
