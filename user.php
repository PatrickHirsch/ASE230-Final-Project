<?php
//This is the personal page for the user. Should display user's bio, profile image(if there is one), Name of the user who owns the page, and all the albums belonging to this user
//This page on my branch doesn't look as good as index.php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

displaySessionMessage();
processLogout();

$thisUser = null;
if (isset($_GET['id']))
    $thisUser = getUserObject($_GET['id']);
else if (isset($_SESSION['user_id']))
    $thisUser = getUserObject($_SESSION['user_id']);
if ($thisUser == null)
    header("Location: index.php");

$theseImages = getUsersPhotos($thisUser['ID']);
//var_dump($_SESSION['user_status']);
echo echoHeader($thisUser['name'] . '\'s Profile', $thisUser['bio']); ?>


<div class="container">
	<div class="row justify-content-center">
		<div style="width: 95%;padding: 20px;">
			<?php if(isset($_SESSION['user_id']) && $thisUser['ID']==$_SESSION['user_id']) echo '<a href="edituser.php">Edit my profile</a>'; ?>
            <br>
			<?php if(isset($_SESSION['user_id']) && $thisUser['ID']==$_SESSION['user_id']) echo '<a href="uploadImage.php">Upload a New Image</a>'; ?>


		</div>
	</div>
</div>


	

<hr>
<?= generateAlbum(__DIR__); ?>


<!-- pre><?= print_r($theseImages); ?></pre>
<pre><?= print_r($thisUser); ?></pre>
<pre><?= print_r($_SESSION); ?></pre-->

<?= echoFooter() ?>
