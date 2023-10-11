<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

$thisUser=null;
if(isset($_GET['id'])) $thisUser=getUserObject($_GET['id']);
else if(isset($_SESSION['user_id'])) $thisUser=getUserObject($_SESSION['user_id']);
if($thisUser==null) header("Location: index.php");

$theseImages=getUsersPhotos($thisUser['ID']);
?>
<?= echoHeader($thisUser['name'].'\'s Profile',$thisUser['bio']) ?>
	

<div class="container">
	<div class="row justify-content-center">
		<div style="width: 95%;padding: 20px;">
			<?php if(isset($_SESSION['user_id']) && $thisUser['ID']==$_SESSION['user_id']) echo '<a href="edituser.php">Edit my profile</a>'; ?>
			

		</div>
	</div>
</div>


	

<hr>
<?= generateAlbum(["",""]); ?>
		
<!-- pre><?= print_r($theseImages); ?></pre>
<pre><?= print_r($thisUser); ?></pre>
<pre><?= print_r($_SESSION); ?></pre-->

<?= echoFooter() ?>