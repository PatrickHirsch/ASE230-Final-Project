<?php

//Start session
session_start();
require_once('lib/functions.php');
require_once 'header.php';

$userData = importJSON('data/users.json');


//Check if user logged in is Admin (status 3)
checkIfAdmin($userData);


echo echoHeader('Admin Index');?>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php generateAdminUserCards($userData);?>
            </div>
        </div>
    </section>
    <!-- Footer-->
<?= echoFooter();?>