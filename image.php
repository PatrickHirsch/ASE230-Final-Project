<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
require_once('db/db.php');

  $stmt=$pdo->prepare(
    'SELECT ID, name, image_ID, gallery_ID 
    FROM galleries 
    LEFT JOIN img_in_gal ON img_in_gal.gallery_ID = galleries.ID
    WHERE galleries.owner_ID = ?'
  );
	$stmt->execute([$_SESSION['user_id']]);
  $userGalleries=$stmt->fetchAll();

  // adds all gallery ids with the image
  $img_in_gallery = [];
  foreach ($userGalleries as $key => $gallery) {
    if (isset($gallery['image_ID']) && isset($gallery['gallery_ID'])) {
      $img_in_gallery[] = $gallery['ID'];
    }
  }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $galleryId = $_POST['galleries'];

  // finds the difference of the galleries and post request, and post request and galleries
  $add_to_gallery = array_diff($_POST['galleries'], $img_in_gallery);
  $remove_from_gallery = array_diff($img_in_gallery, $_POST['galleries']);

  foreach ($add_to_gallery as $k => $gallery_id) {
    addImgToGal($pdo, $_GET['photoid'], $gallery_id); 
  }
  foreach ($remove_from_gallery as $k => $gallery_id) {
    removeImgToGal($pdo, $_GET['photoid'], $gallery_id); 
  }
}
?>


<?php



$isError=null;

if(!isset($_GET['photoid']))
{	$isError='the photo id is invalid';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) $isError='photo couldn\'t be found';
}


if($isError===null)
{	echo echoHeader('Selected Photo: ' . $selectedImage['name']);

	$isAuthenticatedUser=false;
	if(isset($_SESSION['user_id']))
		if($_SESSION['user_id']==$selectedImage['owner_ID'])
			$isAuthenticatedUser=true;
  echo generateAlbumSquare($pdo,$selectedImage,'.',false,$isAuthenticatedUser);
  $galleries = getGalleries($pdo);

  echo '<details>
  <summary>Add to Gallery</summary>';
  if (count($userGalleries) === 0) {
    echo '<div>no galleries found</div>';
    echo '<a href="createGallery.php" class="btn btn-primary btn-lg">Create Gallery</a>';
  } else { 
    echo '<form name="signUpForm" class="mx-1 mx-md-4" method="POST" 
      action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?photoid=' . $_GET['photoid'] . '"';
        foreach ($userGalleries as $key => $gallery) {
      echo '
          <div class="form-check">
        <input 
        class="form-check-input" 
        type="checkbox" 
        name="galleries[]" 
        value="'.$gallery['ID'].'" 
        id="'.$key.'"
        ' . (in_array($gallery['ID'], $img_in_gallery) ? " checked" : "") . '
        >
      <label class="form-check-label" for="'.$key.'">
        '. $gallery['name'] .'
      </label>
    </div>
      ';
        } 

    echo '
      <button type="submit" class="btn btn-secondary">Submit</button>
    </form>
    ';
  }

  
  echo '</details>';
} else
{	echo echoHeader($isError);;
}
?>


<?= echoFooter() ?>
