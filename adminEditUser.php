<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once 'db/db.php';

$stmt = $pdo->prepare("SELECT ID, name, status FROM users where ID = ? ");
$updateStmt = $pdo->prepare('UPDATE users SET status = ? WHERE id = ?');
$thisUser = null;

if (isset($_GET['id'])) {
    $thisUser = checkIfAdmin($pdo, $_GET['id']);
} 
else if (isset($_SESSION['user_id'])) {
    $thisUser = checkIfAdmin($pdo, $_SESSION['user_id']);
}

if ($thisUser == null)
    header("Location: index.php");


//Process Admin User Ban
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['activateUser'])) {
        $updateStmt->execute([1, $thisUser['ID']]);
        $_SESSION['success_message'] = "This User has been activated.";
        header('Location: adminEditUser.php?id=' . $thisUser['ID']);
        }
    }

    if (isset($_POST['banUser'])) {
        $updateStmt->execute([-1, $thisUser['ID']]);
        $_SESSION['success_message'] = "This User has been banned.";
        header('Location: adminEditUser.php?id=' . $thisUser['ID']);
  }



//Process Admin Photo Removal, Fully deletes photos

?>


<?php
echo echoHeader($thisUser['name'] . '\'s Profile', $thisUser['bio'] ?? '');

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
<div class="d-flex flex-row justify-content-between">
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
    <div class="d-flex justify-content-end w-25 align-self-end align-items-end">
        <a href="admin.php"><button name="toIndex" type="submit">Back to Admin Dashboard</button></a>
    </div>
</div>





<hr>
<?= generateUserAlbum($pdo,$thisUser['ID']); ?>


<?= echoFooter() ?>
