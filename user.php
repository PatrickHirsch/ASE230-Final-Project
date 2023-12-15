<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once 'db/db.php';

//	$stmt = $pdo->prepare("SELECT ID, name, status FROM users where ID = ? ");
//	$updateStmt = $pdo->prepare('UPDATE users SET status = ? WHERE id = ?');
//	$thisUser = null;

if (isset($_GET['id'])) {
    $thisUser = getUserObject($pdo,$_GET['id']);
} else if (isset($_SESSION['user_id'])) {
    $thisUser = getUserObject($pdo,$_SESSION['user_id']);
}
// If the user's status is neither 1 nor 3, set $thisUser to null
if ($thisUser && !in_array($thisUser['status'], [1, 3])) {
    $thisUser = null;
}

// Redirect if $thisUser is null
if ($thisUser == null) {
    header("Location: index.php");
    exit(); // Stop further execution of the script
}
?>

<?php 
  $userId = '';
  if (isset($_GET['id'])) {
    $userId = $_GET['id'];
  } else {
    $userId = $_SESSION['user_id'];
  }
?>

<?= echoHeader($thisUser['name'] . '\'s Profile', $thisUser['bio']) ?>
	
<div class="container">
    <div class="row justify-content-center">
        <div style="width: 95%;padding: 20px;">
      <?php if (isset($_SESSION['user_id']) && $thisUser['ID'] == $_SESSION['user_id']) : ?>
                <a href="edituser.php">Edit my profile</a><br>
                <a href="uploadImage.php">Upload a New Image</a><br>
            <?php endif; ?>
      <a href="galleries.php?user_id=<?=$userId?>">View Galleries</a>
        </div>
    </div>
    <hr>
    
    <?php

	echo generateUserAlbum($pdo,$thisUser['ID']);
?>
</div>
		
<?= echoFooter() ?>
