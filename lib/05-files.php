<?php
if(count($_REQUEST)>0){
	print_r($_POST);
	echo '<pre>';
	print_r($_FILES);
	
	if($_FILES['image1']['size']>100000) die('The image is too large');
	if($_FILES['image2']['size']>100000) die('The image is too large');
	move_uploaded_file($_FILES['image1']['tmp_name'],__DIR__.'/data/image1_'.time().'.'.pathinfo($_FILES['image1']['name'],PATHINFO_EXTENSION));
	move_uploaded_file($_FILES['image2']['tmp_name'],__DIR__.'/data/image2_'.time().'.'.pathinfo($_FILES['image1']['name'],PATHINFO_EXTENSION));
}
?>
<form action="05-files.php" method="POST" enctype="multipart/form-data">
	<input name="email" type="text" /><br />
	<input name="password" type="text" /><br />
	<input name="image1" type="file" /><br />
	<input name="image2" type="file" /><br />
	<button type="submit">Submit form</button>
</form>
<?php