<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

$allUsers=importJSON('data/users.json');;
?>

<?= echoHeader('Users') ?>
		
<?
if($_SESSION['status']==1){
   echo generateUserCards($allUsers);
}else if($_SESSION['status']==3){
echo generateAdminUserCards($userData); }?>
		
<?= echoFooter() ?>