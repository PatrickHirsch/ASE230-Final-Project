<?php
session_start();
require_once('header.php');
require_once('lib/functions.php');

if(!isset($_GET['photoid']))
{	$isError='the photo id is invalid';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) header("Location: index.php");
}

if($selectedImage['owner_ID']!=$_SESSION['user_id']) header("Location: index.php");

$updatedSuccessfully = false;

if (count($_POST) > 0) {
    updateImage($pdo,$_GET['photoid'],$_POST['nameInput']);
    $updatedSuccessfully = true;
	header('Location:image.php?photoid='.$_GET['photoid']);
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

									<div style="text-align:center">
										<img src=<?= $selectedImage['url'] ?> style="width:300px;padding:auto;">
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
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Update Image</button>
                                        </div>


                                    </form>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <div class="btn btn-secondary btn-lg"><a href="<?= 'deleteImage.php?photoid=' . $_GET['photoid'] ?>">Delete Image</a></div>
                                    </div>
                                </div>
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