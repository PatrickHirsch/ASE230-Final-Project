<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
require_once('db/db.php');

if(!(isset($_GET['photoid'])&&isset($_SESSION['user_id'])))
{	echo '<script>window.close();</script>';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) echo '<script>window.close();</script>';
}

if(isset($_GET['stars']))
{	$newStar=intval($_GET['stars']);
	if($newStar>5||$newStar<1) $newStar=-1;
	leaveRating($pdo,$_SESSION['user_id'],$_GET['photoid'],$newStar);
	echo '<script>window.close();</script>';
}
else
{	$oldStar=getUsersRating($pdo,$_SESSION['user_id'],$_GET['photoid']);
}
echo echoHead();
?>

<div style="margin:30px">
	<span style="clear:left;float:left;margin-bottom:1em;margin-right:1em;" >
		<img src="<?= $selectedImage['url'] ?>" width="200">
	</span>
	<h1 class="fw-bolder"><?= $selectedImage['name'] ?></h1>
	<div style="text-align:center;font-size:32pt;padding-top:20pt">
	<?php 
	for($i=1;$i<=5;$i++)
	{	echo '<a href="rateimage.php?photoid='.$_GET['photoid'].'&stars='.$i.'" style="text-decoration:none;">';
		if($oldStar<$i)	echo '☆';
		else			echo '★';
		echo '</a> ';
	}
	?>
	</div>
</div>
<hr>