<?php
<<<<<<< HEAD
//This page shows an admin all the users on the site (both active and non-active). Admins can select a user to go to the admin edit page to change a users status.
//Start session
session_start();
//decode users.json
$userData = json_decode(file_get_contents('data/users.json'), true);
require_once(__DIR__.'/lib/functions.php');
require_once 'header.php';

displaySessionMessage();
processLogout();
=======

//Start session
session_start();
require_once('lib/functions.php');
require_once 'header.php';

$userData = importJSON('data/users.json');

>>>>>>> origin/master

//Check if user logged in is Admin (status 3)
checkIfAdmin($userData);


<<<<<<< HEAD
//Diplay any Session Messages
displaySessionMessage();
=======
>>>>>>> origin/master
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
<<<<<<< HEAD

<?= echoFooter();?>

=======
<?= echoFooter();?>
>>>>>>> origin/master
