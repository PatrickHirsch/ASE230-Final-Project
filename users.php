<?php
<<<<<<< HEAD
//This page displays all users who are active on the site
=======
>>>>>>> 2c4588fa305e3873098c9468183810f6ddc8d011
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

<<<<<<< HEAD
displaySessionMessage();
processLogout();

$allUsers=importJSON('data/users.json');
//var_dump($_SESSION['user_status']);
echo echoHeader('Users'); 
echo generateUserCards($allUsers);

		
echo echoFooter() ?>
=======
$allUsers=importJSON('data/users.json');;
?>

<?= echoHeader('Users') ?>
<section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">	
<?= generateUserCards($allUsers) ?>
</div>
</div>
</section>
		
<?= echoFooter() ?>
>>>>>>> 2c4588fa305e3873098c9468183810f6ddc8d011
