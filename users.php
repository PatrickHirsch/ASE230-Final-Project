<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

$allUsers=importJSON('data/users.json');;
?>

<?= echoHeader('Users') ?>
<section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">	
<?= generateUserCards($pdo,$allUsers) ?>
</div>
</div>
</section>
		
<?= echoFooter() ?>
