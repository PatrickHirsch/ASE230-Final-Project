<title>MyPhotoVault</title>
<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once './db/db.php';
if (!isset($_GET['user_id'])) {
    header('Location: index.php');
}
$welcomeMessage=getUserName($pdo, $_GET['user_id']) . '\'s galleries';

?>
<?= echoHeader($welcomeMessage) ?>

<?= getUserGalleries($pdo, $_GET['user_id']) ?>

<?= echoFooter() ?>


