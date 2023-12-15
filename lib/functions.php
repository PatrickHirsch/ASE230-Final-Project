<?php

function getUserName($pdo, $id) {
  $stmt = $pdo->prepare("SELECT name FROM users WHERE ID = ?");
  $stmt->execute([$id]);
  return $stmt->fetch()['name'];
}
 
function importJSON($filePath)
{	$contents=file_get_contents($filePath);
    if(strpos($contents,"<?php")===0)
    {	$contents=explode("\n",$contents);
        array_shift($contents);
        $contents=implode("\n",$contents);
    }
    return json_decode($contents,true);
}

/**
 * Finds the index of a photo
 *
 * @param array $imagesJson an associative array of image data
 * @param string|int $photoId id of the photo to find
 *
 * @return string|int|null returns a string or int number, or null if not found
 */
function findJsonIdIndex($imagesJson, $photoId) {
    $selectedImageIndex = null;

// sets selected image to the image in the GET req
    foreach ($imagesJson as $index => $image) {
        if ($image['id'] === $photoId) {
            $selectedImageIndex = $index;
            break;
        }
    }
    return $selectedImageIndex;
}

function generateAlbum($pdo,$rootPath='.')
{	$sqlResponce=getImagesAll($pdo);
	
    if (count($sqlResponce)<1) return '<div>No images at this time</div>';
	
    $ret='
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
	foreach($sqlResponce as $id) 
	{	$img=getImage($pdo,$id['ID']);
		if(getUserObject($pdo,$img['owner_ID'])['status']!=-1)	////////////////////////
			$ret=$ret.generateAlbumSquare($pdo,$img,$rootPath,true,false);
	}
	$ret=$ret.'
                </div>
            </div>
        </section>
	';
	return $ret;
}

function generateGallery($pdo, $id, $rootPath='.')
{
    $stmt=$pdo->prepare('
        SELECT *
         FROM img_in_gal 
         INNER JOIN images ON images.ID = img_in_gal.image_ID 
         WHERE gallery_ID=?; 
     ');
    $stmt->execute([$id]);
    $gallery = $stmt->fetchAll();
    if (count($gallery)<1) return '<div>No images at this time</div>';
	
    $ret='
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
	foreach($gallery as $img)
	{
       $ret .= generateAlbumSquare($pdo, $img);

	}
	$ret=$ret.'
                </div>
            </div>
        </section>
	';
    $owner_gallery = getGallery($pdo, $id);
    $isAuthenticatedUser=false;
    if(isset($_SESSION['user_id'])) {
        if($_SESSION['user_id'] == $owner_gallery['owner_ID']) {
            $isAuthenticatedUser = true;
        }
    }
    if ($isAuthenticatedUser) {
        $ret .= '<div class="d-flex justify-content-center">';
        $ret .= '<a class="btn btn-outline-dark mt-auto" href="editGallery.php?id=' . $owner_gallery['ID'] . '">Edit Gallery</a>';
        $ret .= '</div>';
    }
	return $ret;
}

function getUserGalleries($pdo, $id, $rootPath='.')
{
    $galleries = getGalleriesById($pdo, $id);

    $isAuthenticatedUser=false;
	$userID=-1;
	if(isset($_SESSION['user_id'])) $userID=$_SESSION['user_id'];
	if($userID==$id) $isAuthenticatedUser=true;

    $ret='
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
    foreach($galleries as $gallery)
    {	
		if(canViewGallery($pdo,$gallery['ID'],$userID))
			$ret .= generateGallerySquare($gallery, $isAuthenticatedUser);

    }
    $ret=$ret.'
                </div>
            </div>
        </section>
	';
    if ($isAuthenticatedUser) {
        $ret .= '<a href="createGallery.php" class="btn btn-outline-dark mt-auto">Create Gallery</a>';
    }
    return $ret;
}

function generateGallerySquare($gallery, $isAuthenticated) {
    $ret='
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <!-- div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div -->
                            <!-- Product image-->
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">'.$gallery['name'].'</h5>
                                    <!-- Product reviews-->
                                    <p>'.$gallery['description'].'</p>
                                    <div class="d-flex justify-content-center small text-warning mb-2">';
    $ret .= '</div>
                                    <!-- Product price-->
                                    <a class="btn btn-outline-dark mt-auto"href="gallery.php?gallery_id='.$gallery['ID'].'">View Gallery</a>';
                                if ($isAuthenticated) {
                                    $ret .= '<br><a class="text-muted" href="editGallery.php?id='.$gallery['ID'].'">Edit Gallery</a>';
                                }
                               $ret .= '</div>
                            </div>
                            <!-- Product actions-->
                            ';
    $ret .= '
                        </div>
                    </div>
    ';
    return $ret;
}

//Builds the section where user's photos should be displayed
function generateUserAlbum($pdo,$userID,$rootPath='.')
{	$sqlResponce=getImagesFromUser($pdo,$userID);
	
    if (count($sqlResponce)<1) return '<div>No images at this time</div>';
	
    $ret='
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
	foreach($sqlResponce as $id) 
	{	$img=getImage($pdo,$id['ID']);
		if(true)//getUserObject($img['owner'])['status']!=2)	////////////////////////
			$ret=$ret.generateAlbumSquare($pdo,$img,$rootPath,true,false);
	}
	$ret=$ret.'
                </div>
            </div>
        </section>
	';
	return $ret;
}

//Builds individual cards for each image associated with a user
function generateAlbumSquare($pdo,$img,$rootPath='.', $viewImageButton=true,$deleteImageButton=false)
{	if(isset($_SESSION['user_id'])&&($img['owner_ID']==$_SESSION['user_id'])) $deleteImageButton=true;
	else $deleteImageButton=false;
    $ret='
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <!-- div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div -->
                            <!-- Product image-->
                            <img class="card-img-top" src="'. $img['url'] .'" alt="' . $img['name'] . ' image" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">'.$img['name'].'</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">';
	for($star=1;$star<=getRating($pdo,$img['ID']);$star++)	$ret=$ret.'<div class="bi-star-fill"></div>';
	if(isset($_SESSION['user_id'])) $ret=$ret.'<a href="#" onClick="MyWindow=window.open(\'rateimage.php?photoid='.$img['ID'].'\',\'MyWindow\',\'width=600,height=300\'); return false;">';
$ret=$ret.'('.getRating($pdo,$img['ID']).') ';
	if(isset($_SESSION['user_id'])) $ret=$ret.'</a>';
    $ret=$ret.'</div>
                                    <!-- Product price-->
                                    <a class="text-muted" href="user.php?id='.$img['owner_ID'].'">'. getUserName($pdo,$img['owner_ID']) .'</a>
                                </div>
                            </div>
                            <!-- Product actions-->
                            ';
                            if ($viewImageButton) $ret=$ret.'
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="' . './' . 'image.php?photoid=' . $img['ID'] . '">View image</a></div>
                            </div>';
                            if ($deleteImageButton) $ret=$ret.'
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="' . './' . 'editImage.php?photoid=' . $img['ID'] . '">Edit/Delete image</a></div>
                            </div>';
	$ret=$ret.'
                        </div>
                    </div>
	';
    return $ret;
}


//Selects one specific user from the JSON
function getUserObject($pdo,$id)
{	$stmt=$pdo->prepare('SELECT * FROM users WHERE id=?');
	$stmt->execute([$id]);
	$ret=$stmt->fetch();
	return $ret;



	$allUsers=importJSON('data/users.json');
	foreach($allUsers as $user)
		if($user[$field]==$lookup)
			return $user;
	return null;
}

//gets users photos?
function getUsersPhotos($userID)
{	$allImages=importJSON('data/images.json');
	$ret=[];
			//foreach image, if ownerID==userID add to $ret
	foreach($allImages as $img)
		if($img['owner']==$userID)
			$ret[]=$img;
	return $allImages;
}


//converts php time() to an actual time and date according to our local time.
function convertTimeStamp($user)
{
  if (isset($user['date_joined'])) {
    date_default_timezone_set('America/Kentucky/Louisville');
    $userTimeStamp = strtotime($user['date_joined']);
    $formattedDateTime = date('Y-m-d H:i:s', $userTimeStamp);
    return $formattedDateTime;
  }
}

//Generates user cards for admin.php
function generateAdminUserCards($pdo)
{
  $stmt = $pdo->query("SELECT ID, name, date_joined, status FROM users");
  $stmt->execute();

  while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $status = $user['status'];
      switch ($status) {
          case (-1):
              $userStatus = "Admin Blocked";
              break;
          case (0):
              $userStatus = "User Deleted";
              break;
          case (1):
              $userStatus = "Active User";
              break;
          case (3):
              $userStatus = "Admin";
              break;
      }
      echo '<div class="col mb-5">
                      <div class="card h-100">
                          <!-- User Profile image-->
                          <img class="card-img-top" src="' . getProfilePhoto($pdo, $user['ID']) . '" alt="Image of ' . $user['name'] . '" />
                          <!-- User details-->
                          <div class="card-body p-4">
                              <div class="text-center">
                                  <!-- User name-->
                                  <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                  <!-- User Start Date-->
                                  <div class="text-center">' . convertTimeStamp($user) . '</div>
                                  <!-- User Status-->
                                  <div class="text-center">' . $userStatus . '</div>
                              </div>
                          </div>
                          <!-- User actions-->
                          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                              <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="adminEditUser.php?id=' . $user['ID'] . '">Check out User</a></div>
                          </div>
                          </form>
                      </div>
                  </div>';
  }

    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status = $user['status'];
        switch ($status) {
            case (-1):
                $userStatus = "Admin Blocked";
                break;
            case (0):
                $userStatus = "User Deleted";
                break;
            case (1):
                $userStatus = "Active User";
                break;
            case (3):
                $userStatus = "Admin";
                break;
        }
        echo '<div class="col mb-5">
                        <div class="card h-100">
                            <!-- User Profile image-->
                            <img class="card-img-top" src="' . getProfilePhoto($pdo, $user['ID']) . '" alt="Image of ' . $user['name'] . '" />
                            <!-- User details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- User name-->
                                    <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                    <!-- User Start Date-->
                                    <div class="text-center">' . convertTimeStamp($user) . '</div>
                                    <!-- User Status-->
                                    <div class="text-center">' . $userStatus . '</div>
                                </div>
                            </div>
                            <!-- User actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="adminEditUser.php?id=' . $user['ID'] . '">Check out User</a></div>
                            </div>
                            </form>
                        </div>
                    </div>';
    }

}

//generates user cards for index.php
function generateUserCards($pdo)
{	$userData=getUsersAll($pdo);

	$ret="";

    foreach ($userData as $user)
	{	$user=getUserObject($pdo,$user['ID']);
		$status = $user['status'];
		$profilePhoto=getProfilePhoto($pdo, $user['ID']);

        if ($status == 1 || $status == 3)
		{	$ret=$ret.'<div class="col mb-5">
                            <div class="card h-100">
                                <!-- User Profile image-->
                                <img class="card-img-top rounded-circle" style="width: 200px;height: 200px;object-fit: cover;margin: auto;" src="' . $profilePhoto . '" alt="Image of ' . $user['name'] . '" />
                                <!-- User details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- User name-->
                                        <h5 class="fw-bolder">' . $user['name'] . '</h5>
                                        <!-- User Start Date-->
                                        <div class="text-center">' . convertTimeStamp($user) . '</div>
                                    </div>
                                </div>
                                <!-- User actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="user.php?id=' . $user['ID'] . '">Check out User</a></div>
                                </div>
                            </div>
                        </div>';
        }

    }
	return $ret;
}

function getProfilePhoto($pdo, $userID)
{
    $stmt=$pdo->prepare('SELECT profile_image FROM users WHERE id=?');
    $stmt->execute([$userID]);
    $ret=$stmt->fetch();
	return $ret['profile_image'] ?? 'data/profilePhotos/0';
}

//checks if a user has admin access. If user does not have admin access the are automatically logged out and session is distroyed.
function checkIfAdmin($pdo, $id)
{
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_status'] != 3) {
            session_destroy();
            echo "<a href=\"login.php\">Back to Login</a> </br>";
            die('You are not an admin. Go to naughty jail');
        } else {
            $stmt = $pdo->prepare("SELECT ID, name, status FROM users where ID = ? ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } else {
        echo "<a href=\"login.php\">Back to Login</a> </br>";
        die('You are not logged in. Please Login before continuing');
    }
}

function echoErrors($textArray)
{
  foreach ($textArray as $_ => $text)
  {
    echo $text;
  }
}

function commentSectionForm($pdo, $selectedImage, $user){
    echo '<div>
    <form method="POST">
    <div class="form-group">
    <label for="addCommentSection">Comment:</label>
    <input type="hidden" name="photoid" value="'.$selectedImage['ID'].'">
    <textarea class="form-control" name="message" id="commentTextarea" rows="3"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>';
}

function generateCommentSection($pdo, $selectedImage) {
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE image_id = ?');
    $stmt->execute([$selectedImage['ID']]);
    $thisImageComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($thisImageComments) {
        foreach ($thisImageComments as $comment) 
		{	if(getUserObject($pdo,$comment['user_ID'])['status']!=-1)
			{	echo '<div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">';
				fillComment($pdo, $comment);
				echo '</li>
					</ul>
				</div>';
			}
        }
    }
}

function fillComment($pdo, $comment) {
    $posterProfileImage = getProfilePhoto($pdo, $comment['user_ID']);
    $posterName = getUserName($pdo, $comment['user_ID']);
    $commentText = $comment['message'];
    $commentID = $comment['ID'];

    echo '<div class="container">
        <div class="media">
            <img class="align-self-start mr-3 rounded-circle" src="' . $posterProfileImage . '" alt="Profile Image" width="10%" height="10%">
            <div class="media-body">
                <h5 class="mt-0">' . $posterName . '</h5>
                <p>' . $commentText . '</p>
            </div>';
			if (isset($_SESSION['user_id']))
            {	if($comment['user_ID']=== $_SESSION['user_id'])
				{	echo '<div>
					<form method="GET" action="editcomment.php">
					<input type="hidden" name="commentid" value="' . $commentID . '">
					<button type="submit" class="btn btn-primary">Edit Comment</button>
					</form>
					</div>';
				}
				if(isAdmin($pdo,$_SESSION['user_id']))
				{	echo '<div>
					<form method="POST" action="editcomment.php?commentid='.$commentID.'">
					<input type="hidden" name="delete">
					<button type="submit" class="btn btn-primary">Admin Delete</button>
					</form>
					</div>';
				}
			}
        echo '</div>
        <hr>
    </div>';
}

function getComment($pdo, $id)
{
        $stmt =$pdo->prepare("SELECT *  FROM comments WHERE ID = ?");
        $stmt->execute([$id]);
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    return (object) $comment ? $comment : null;
}




//SQL QUEREYS //////////////

function createImage($pdo,$ownerID,$filename,$name)
{	$stmt=$pdo->prepare('INSERT INTO images (owner_ID,filename,name,url) VALUES (?,?,?,?)');
	$stmt->execute([$ownerID,$filename,$name,'data/images/'.$filename]);
}
function getImage($pdo,$id)
{	$stmt=$pdo->prepare('SELECT * FROM images WHERE id=?');
	$stmt->execute([$id]);
	$ret=$stmt->fetch();
	return $ret;
}
function updateImage($pdo,$id,$newName)
{	$stmt=$pdo->prepare('UPDATE images SET name = ? WHERE ID = ?');
	$stmt->execute([$newName,$id]);
}
function deleteImage($pdo,$id)
{	$stmt=$pdo->prepare('DELETE FROM images WHERE id=?');
	$stmt->execute([$id]);
}

// Takes an image ID and returns its rating, an average calculated from individual ratings
function getRating($pdo,$imgID)
{	$ret=0;
	$stmt=$pdo->prepare('SELECT AVG(stars) AS star FROM ratings WHERE img_ID = ?;');
	$stmt->execute([$imgID]);
	$ret=$stmt->fetch();
	return $ret['star'];
}
function getUsersRating($pdo,$userID,$imgID)
{	$ret=0;
	$stmt=$pdo->prepare('SELECT stars FROM ratings WHERE img_ID = ? AND user_ID = ?;');
	$stmt->execute([$imgID,$userID]);
	$ret=$stmt->fetch();
	if(!isset($ret['stars'])) return -1;
	return $ret['stars'];
}
function leaveRating($pdo,$userID,$imgID,$stars=-1)
{	$stmt=$pdo->prepare('DELETE FROM ratings WHERE user_ID = ? AND img_ID = ?;');
	$stmt->execute([$userID,$imgID]);
	
	if($stars<0) return;
	
	$stmt=$pdo->prepare('INSERT INTO ratings (user_ID,img_ID,stars) VALUES (?,?,?);');
	$stmt->execute([$userID,$imgID,$stars]);
}



function createGallery($pdo,$userID,$vis,$name,$desc)
{	$stmt=$pdo->prepare('INSERT INTO galleries (owner_ID,visibility,name,description) VALUES (?,?,?,?);');
	$stmt->execute([$userID,$vis,$name,$desc]);
}
function getGallery($pdo,$galID)
{	$stmt=$pdo->prepare('SELECT * FROM galleries WHERE id=?');
	$stmt->execute([$galID]);
	$ret=$stmt->fetch();
	return $ret;
}
function canViewGallery($pdo,$galID,$userID)
{	$thisGal=getGallery($pdo,$galID);
	if($thisGal['visibility']==1) 		return true;
	if($thisGal['owner_ID']==$userID)	return true;
	return false;
}
function getGalleriesById($pdo, $owner_id) 
{
	$stmt=$pdo->prepare('SELECT * FROM galleries WHERE owner_ID = ?');
	$stmt->execute([$owner_id]);
  $ret = [];
  while ($row = $stmt->fetch()) {
    $ret[] = $row;
  }
	return $ret;
}
function updateGallery($pdo,$galID,$vis=-1,$name=null,$desc=null)
{	$pre=getGallery($pdo,$galID);
	if($vis==-1)	$vis=$pre['visibility'];
	if($name==null)	$name=$pre['name'];
	if($desc==null)	$desc=$pre['description'];
	$stmt=$pdo->prepare('UPDATE galleries SET visibility=?, name=?, description=? WHERE ID=?');
	$stmt->execute([$vis,$name,$desc,$galID]);
}
function deleteGallery($pdo,$galID)
{	$stmt=$pdo->prepare('DELETE FROM img_in_gal WHERE gallery_ID = ? ');
	$stmt->execute([$galID]);
    $stmt=$pdo->prepare('DELETE FROM galleries WHERE ID = ?');
    $stmt->execute([$galID]);
}
function addImgToGal($pdo,$imgID,$galID)
{	$stmt=$pdo->prepare('INSERT INTO img_in_gal (image_id,gallery_ID) VALUES (?,?);');
	$stmt->execute([$imgID,$galID]);
}
function getImagesFromGal($pdo,$galID)
{	$stmt=$pdo->prepare('SELECT image_ID FROM img_in_gal WHERE gallery_ID=?');
	$stmt->execute([$id]);
	$ret=$stmt->fetch();
	return $ret;
}
function removeImgToGal($pdo,$imgID,$galID)
{	$stmt=$pdo->prepare('DELETE FROM img_in_gal WHERE image_id=? AND gallery_ID=?');
	$stmt->execute([$imgID,$galID]);
}



// Returns all image IDs on the site
function getImagesAll($pdo)
{	$stmt=$pdo->prepare('SELECT ID FROM images ORDER BY timestamp DESC');
	$stmt->execute([]);
	$ret=$stmt->fetchAll();
	return $ret;
}
function getImagesFromUser($pdo,$userID)
{	$stmt=$pdo->prepare('SELECT ID FROM images WHERE owner_id=? ORDER BY timestamp DESC');
	$stmt->execute([$userID]);
	$ret=$stmt->fetchAll();
	return $ret;
}
function getUsersAll($pdo)
{	$stmt=$pdo->prepare('SELECT ID FROM users ORDER BY date_joined DESC');
	$stmt->execute([]);
	$ret=$stmt->fetchAll();
	return $ret;
}
function isAdmin($pdo,$userID)
{	$status=getUserObject($pdo,$userID)['status'];
	if($status==3) return true;
	return false;
}
?>
