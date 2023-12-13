<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once 'db/db.php';


$errors = [];
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (count($_POST) > 0) {
    if (
      !isset($_POST['galleryName']) ||
      !isset($_POST['visibility'])
  ) {
      $errors[] = 'Gallery Name and Visibility are required Fields';
    }
    else {
      createGallery(
        $pdo, 
        $_SESSION['user_id'], 
        ($_POST['visibility'] === 'public') ? 1 : 0, 
        $_POST['galleryName'],
        $_POST['description']
      );
    }
  }  
}
?>
<?= echoHeader('Create Gallery') ?>
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
                                if (count($errors) === 0 && count($_POST) > 0) {
                                  echo 'Gallery created Successfully';
                                }
                                ?>

                                <!-- p name="signUpformDiv" class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up
                                </p -->
                                <form name="signUpForm" class="mx-1 mx-md-4" method="POST"
                                    action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

                                    <div class=" d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nameInput">Gallery Name</label>
                                            <input type="text" id="nameInput" name="galleryName" class="form-control" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <div>Visibility</div><br>
                                            <input type="radio" id="private" name="visibility" value="private" class="form-check-input" />
                                            <label class="form-check-label" for="visibility">Private</label>
                        <br>
                                            <input type="radio" id="visibility" name="visibility" value="public" class="form-check-input" checked="checked"/>
                                            <label class="form-check-label" for="visibility" >Public</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>



                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Create Gallery</button>
                                    </div>


                                </form>
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

