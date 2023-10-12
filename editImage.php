<?php
session_start();
require_once('header.php');
require_once('lib/functions.php');

$imagesJson = importJSON('./data/images.json');

if (!isset($_GET['photoid'])) {
    die('No photo ID');
}

$selectedImageIndex = findJsonIdIndex($imagesJson, $_GET['photoid']);

if ($selectedImageIndex === null) {
    die('Photo could not be found with id of' . $_GET['photoid']);
}

$selectedImage = $imagesJson[$selectedImageIndex];


if ($selectedImageIndex === null) {
    die('photo couldn\'t be found');
}

if ($selectedImage['owner'] !== $_SESSION['user_id']) {
    die('You are not authorized to view this page');
}

$updatedSuccessfully = false;

if (count($_POST) > 0) {
    $selectedImage['name'] = $_POST['nameInput'];
    $selectedImage['rating'] = $_POST['ratingInput'];
    $imagesJson[$selectedImageIndex] = $selectedImage;

    writeJSON($imagesJson, 'data/images.json');
    $updatedSuccessfully = true;
}
?>
<?= echoHeader('Edit Image') ?>
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

                                    <!-- p name="signUpformDiv" class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up
                                    </p -->
                                    <div style="color: green;">
                                        <?php if ($updatedSuccessfully) echo 'Photo edited successfully' ?>
                                    </div>
                                    <form name="signUpForm" class="mx-1 mx-md-4" method="POST"
                                          action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?photoid=' . $_GET['photoid']) ?>">


                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="nameInput">Name</label>
                                                <input type="text" id="nameInput" name="nameInput" class="form-control" value="<?= $selectedImage['name'] ?>" required/>
                                            </div>
                                        </div>

                                        <div class=" d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="ratingInput">Rating</label>
                                                <select name="ratingInput" id="ratingInput" class="form-select">
                                                    <?php
                                                    for ($i = 0; $i <= 5; $i++) {
                                                        if ($selectedImage['rating'] == $i) {
                                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                                        } else {
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Update Image</button>
                                        </div>


                                    </form>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <div class="btn btn-secondary btn-lg"><a href="<?= 'deleteImage.php?photoid=' . $_GET['photoid'] ?>">Delete Image</a></div>
                                    </div>
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