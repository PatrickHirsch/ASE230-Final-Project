<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
$userData = json_decode(file_get_contents('data/users.json'), true);
checkIfAdmin($userData);

//display any session messages
displaySessionMessage();

if (isset($_GET['id'])) {
    $thisUser = getUserObject($_GET['id']);
    //var_dump($_GET['id']);
} else if (isset($_SESSION['user_id']))
    $thisUser = getUserObject($_SESSION['user_id']);
if ($thisUser == null)
    header("Location: index.php");

$theseImages = getUsersPhotos($thisUser['ID']);

//Process Admin User Ban
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['activateUser'])) {
        foreach ($userData as &$user) {
            if ($user['ID'] === $thisUser['ID']) {
                $user['status'] = "1"; // Update the user's status
            }
        }

        // Save the updated user data to the JSON file
        file_put_contents('data/users.json', json_encode($userData, JSON_PRETTY_PRINT));

        $_SESSION['success_message'] = "This User has been activated.";
        header('Location: adminEditUser.php?id=' . $thisUser['ID']);
    }


    if (isset($_POST['banUser'])) {
        foreach ($userData as &$user) {
            if ($user['ID'] === $thisUser['ID']) {
                $user['status'] = "-1"; // Update the user's status
            }
        }

        // Save the updated user data to the JSON file
        file_put_contents('data/users.json', json_encode($userData, JSON_PRETTY_PRINT));

        $_SESSION['success_message'] = "This User has been banned.";
        header('Location: adminEditUser.php?id=' . $thisUser['ID']);
    }

}



//Process Admin Photo Removal, Fully deletes photos

?>


<?php
echo echoHeader($thisUser['name'] . '\'s Profile', $thisUser['bio']);

$status = $thisUser['status'];
switch ($status) {
    case (-1):
        echo '<div class="d-flex p-2 bg-danger text-white">This user is Admin Blocked</div>';
        break;
    case (0):
        echo '<div class="d-flex p-2 bg-primary text-white">This user is Deleted</div>';
        break;
    case (1):
        echo '<div class="d-flex p-2 bg-success text-white">This user is Active</div>';
        break;
    case (3):
        echo '<div class="d-flex p-2 bg-warning text-white">This user is a Admin</div>';
        break;
}
?>
<!-- Admin Navigation-->
<div class="d-flex flex-column">
    <div class="d-flex justify-content-start">
        <form method="POST" action="">

            <?php
            if ($thisUser['status'] == '1') {
                echo '
            <button name="banUser" type="submit">Ban User Account</button>';
            } else if ($thisUser['status'] == '-1') {
                echo '
            <button name="activateUser" type="submit">Activate User Account</button>';
            }

            ?>
        </form>
    </div>
    <div class="d-flex justify-content-end">
        <a href="adminIndex.php"><button name="toAdminIndex" type="submit">Back to Admin Index</button></a>
    </div>
</div>





<hr>
<?= generateUserAlbum($thisUser['ID']); ?>

<!-- pre><?= print_r($theseImages); ?></pre>
<pre><?= print_r($thisUser); ?></pre>
<pre><?= print_r($_SESSION); ?></pre-->

<?= echoFooter() ?>