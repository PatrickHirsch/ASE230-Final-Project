<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

$allUsers=importJSON('data/users.json');;
?>

<?= echoHeader('Users') ?>
		
<?= generateUserCards($allUsers) ?>
		
<?= echoFooter() ?>