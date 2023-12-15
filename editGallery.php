<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once 'db/db.php';

$errors = [];
if (!isset($_GET['id'])) {
  header('Location: index.php');
}

if(!isset($_SESSION['user_id'])) header('Location: index.php');
$gallery = getGallery($pdo, $_GET['id']);
if(!$gallery) header('Location: index.php');
if($gallery['owner_ID']!=$_SESSION['user_id']) header('Location: index.php');




$stmt=$pdo->prepare('
        SELECT *
         FROM img_in_gal 
         INNER JOIN images ON images.ID = img_in_gal.image_ID 
         WHERE gallery_ID=?; 
     ');
$stmt->execute([$_GET['id']]);
$images = $stmt->fetchAll();

if (($gallery['visibility'] == '0' && $gallery['owner_ID'] != $_SESSION['user_id'])) {
  header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (count($_POST) > 0) {
    if ($_POST['action'] === 'delete') {
      deleteGallery($pdo, $_GET['id']);
    }
    else {
      if (
        !isset($_POST['galleryName']) ||
        !isset($_POST['visibility'])
    ) {
        $errors[] = 'Gallery Name and Visibility are required Fields';
      }
      else {
		updateGallery(
          $pdo, 
          (int)$_GET['id'], 
          $vis=($_POST['visibility'] === 'public') ? 1 : 0, 
          $name=$_POST['galleryName'],
          $desc=$_POST['description']
        );
		foreach ($_POST['images'] as $imgID) removeImgToGal($pdo,$imgID,$_GET['id']);
		header('Location: gallery.php?gallery_id='.$_GET['id']);
      }

    }
  }  
}

?>
<?= echoHeader('Update Gallery') ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
<body>
<section style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <?= echoErrors($errors); ?>
                  <?php 
                              $action = $_POST['action'] ?? '';
                              if ($action === 'delete') {
                                if (count($errors) === 0) {
                                  echo 'Gallery deleted Successfully';
                                }
                              } else {
                                if (count($errors) === 0 && count($_POST) > 0) {
                                  echo 'Gallery updated successfully';
                                }
                                  echo '<form name="signUpForm" class="mx-1 mx-md-4" method="POST" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $_GET['id'] . '">
                                      <div class=" d-flex flex-row align-items-center mb-4">
                                          <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                          <div class="form-outline flex-fill mb-0">
                                              <label class="form-label" for="nameInput">Gallery Name</label>
                                              <input type="text" id="nameInput" name="galleryName" class="form-control" value="' . htmlspecialchars($gallery['name']) . '" required/>
                                          </div>
                                      </div>

                                      <div class="d-flex flex-row align-items-center mb-4">
                                          <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                          <div class="form-outline flex-fill mb-0">
                                              <div>Visibility</div><br>
                                              <input type="radio" id="private" name="visibility" value="private" class="form-check-input" ' . ($gallery['visibility'] == '0' ? 'checked' : '') . '/>
                                              <label class="form-check-label" for="visibility">Private</label>
                                              <br>
                                              <input type="radio" id="public" name="visibility" value="public" class="form-check-input" ' . ($gallery['visibility'] == '1' ? 'checked' : '') . '/>
                                              <label class="form-check-label" for="visibility" >Public</label>
                                          </div>
                                      </div>

                                      <div class="d-flex flex-row align-items-center mb-4">
                                          <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                          <div class="form-outline flex-fill mb-0">
                                              <label class="form-label" for="description">Description</label>
                                              <textarea class="form-control" name="description" id="description" cols="30" rows="10">' . htmlspecialchars($gallery['description']) . '</textarea>
                                          </div>
                                      </div>
                                      <div>Delete</div>
                                      ';

                                  foreach ($images as $key => $image) {
                                      echo '
                                          <div class="form-check">
                                            <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="images[]" 
                                            value="'.$image['image_ID'].'" 
                                            id="'.$key.'"
                                            >
                                          <label class="form-check-label" for="'.$key.'">
                                            '. $image['name'] .'
                                          </label>
                                        </div>
                                            ';

                                  }

                                echo  '<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                          <button type="submit" id="update" name="action" value="update" class="btn btn-primary btn-lg">Update Gallery</button>
                                      </div>
                                      <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                          <button type="submit" id="delete" value="delete" name="action" class="btn btn-secondary btn-lg">Delete Gallery</button>
                                      </div>
                                  </form>';
                                }
                                ?>

                                <!-- p name="signUpformDiv" class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up
                                </p -->
                            </div>
<?php
//	<div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
//	<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">
//	</div>
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<?= echoFooter() ?>
