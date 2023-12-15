<?php
session_start();
require_once('./lib/functions.php');
require_once('./header.php');
require_once('db/db.php');

$isError=null;

if(!isset($_GET['photoid']))
{	$isError='the photo id is invalid';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) $isError='photo couldn\'t be found';
}

if (isset($_SESSION['user_id'])) {
	if(isAdmin($pdo,$_SESSION['user_id'])) echo '<a href="deleteImage.php?photoid='.$_GET['photoid'].'"><button type="submit" name="adminRemove" class="btn btn-primary">Admin Remove</button></a>';

    $stmt=$pdo->prepare(
        'SELECT ID, name, image_ID, gallery_ID 
  FROM galleries 
    LEFT JOIN img_in_gal ON img_in_gal.gallery_ID = galleries.ID
    WHERE galleries.owner_ID = ?'
    );
	$InsertStmt = $pdo ->prepare('INSERT INTO comments (ID, user_ID, image_ID,message,timestamp) VALUES (?, ?, ?,?,?)');
	$isError=null;

	
    $stmt->execute([$_SESSION['user_id']]);
    $userGalleries=$stmt->fetchAll();
    $uniqueIds = [];
    $preferedImageId = [];
    $filteredGallery = [];

    foreach ($userGalleries as $element) {
        $id = $element['ID'];
        $imageId = $element['image_ID'];

        if (!in_array($id, $uniqueIds)) {
            if ($imageId == $_GET['photoid']) {
                $filteredGallery[] = $element;
                $uniqueIds[] = $id;
            } elseif (!isset($preferedImageId[$id])) {
                $preferedImageId[$id] = $element;
            }
        }
    }

    foreach ($preferedImageId as $id => $element) {
        if (!in_array($id, $uniqueIds)) {
            $filteredGallery[] = $element;
        }
    }

    function compareById($a, $b) {
        return (int)$a['ID'] - (int)$b['ID'];
    }

    usort($filteredGallery, 'compareById');

    $img_in_gallery = [];

    foreach ($userGalleries as $key => $gallery) {
        if (isset($gallery['image_ID']) && isset($gallery['gallery_ID']) && $gallery['image_ID'] == $_GET['photoid']) {
            $img_in_gallery[] = $gallery['ID'];
        }

    }





    if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		// Check if the form field 'message' is set and not empty
		if (isset($_POST['message']) /*&& !empty($_POST['commentTextarea'])*/)
		{	// Retrieve data from form submission
			$userID = $_SESSION['user_id']; 
			$imageID = $selectedImage['ID']; 
			$message = $_POST['message'];
			$timestamp = date('Y-m-d H:i:s'); // Current timestamp
	
			// Prepare the SQL query
			$insertStmt = $pdo->prepare("INSERT INTO comments (user_id, image_id, message, timestamp ) VALUES (?, ?, ?, ?)");
	
			// Execute the query with provided values
			$insertStmt->execute([$userID, $imageID, $message, $timestamp]);
	
			header("");
		}
		else if(isset($_POST['galleries']))
		{	$galleryId = $_POST['galleries'] ?? [];
	
			$postGalleries = $_POST['galleries'] ?? [];
			$add_to_gallery = array_diff($postGalleries, $img_in_gallery);
			$remove_from_gallery = array_diff($img_in_gallery, $postGalleries);
	
	
			foreach ($remove_from_gallery as $k => $gallery_id) {
				removeImgToGal($pdo, $_GET['photoid'], $gallery_id);
			}
			foreach ($add_to_gallery as $k => $gallery_id) {
				addImgToGal($pdo, $_GET['photoid'], $gallery_id);
			}
		}
		else{}
}
}

?>


<?php
if($isError===null)
{	echo echoHeader('Selected Photo: ' . $selectedImage['name']);

	$isAuthenticatedUser=false;
	if(isset($_SESSION['user_id']))
		if($_SESSION['user_id']==$selectedImage['owner_ID'])
			$isAuthenticatedUser=true;
  echo generateAlbumSquare($pdo,$selectedImage,'.',false,$isAuthenticatedUser);
  if (isset($_SESSION['user_id'])) {

      echo '<details>
  <summary>Add to Gallery</summary>';
      if (count($userGalleries) === 0) {
          echo '<div>no galleries found</div>';
          echo '<a href="createGallery.php" class="btn btn-primary btn-lg">Create Gallery</a>';
      } else {
          echo '<form name="signUpForm" class="mx-1 mx-md-4" method="POST" 
      action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?photoid=' . $_GET['photoid'] . '"';
          foreach ($filteredGallery as $key => $gallery) {
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
        <br>
      <button type="submit" class="btn btn-secondary">Submit</button>
    </form>
    ';
      }


      echo '</details>';
  }
  
	//call function to generate form allowing users to post comments.
	echo commentSectionForm($pdo, $selectedImage, $isAuthenticatedUser);
	echo generateCommentSection($pdo, $selectedImage);

} else
{	echo echoHeader($isError);;
}
?>


<?= echoFooter() ?>
