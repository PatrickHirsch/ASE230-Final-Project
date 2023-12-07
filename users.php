<?php
//This page displays all users who are active on the site
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

displaySessionMessage();
processLogout();

$allUsers=importJSON('data/users.json');
//var_dump($_SESSION['user_status']);
echo echoHeader('Users'); 
echo generateUserCards($allUsers);

		
echo echoFooter() ?>
