<?php
session_start();
require_once('header.php');
require_once('./lib/imageHandling.php');
require_once('lib/functions.php');
?>

<?php
$isError=null;

if(!(isset($_GET['photoid'])&&isset($_SESSION['user_id'])))
{	$isError='photo or user could not be identified';
}
else
{	$selectedImage=getImage($pdo,$_GET['photoid']);
	if(!$selectedImage) $isError='photo could not be found';
	elseif(($selectedImage['owner_ID']!=$_SESSION['user_id'])&&!isAdmin($pdo,$_SESSION['user_id'])) $isError='You are not authorized to view this page';
}

if($isError===null)
{	$updatedSuccessfully=false;
	if(count($_POST)>0)
	{	if ($_POST['delete']==='true')
		{	deleteImage($pdo,$_GET['photoid']);
			$updatedSuccessfully=true;
		}
	}
}
else
{	echo echoHeader($isError);
	header('Location: index.php');
}
?>
<?= echoHeader('Delete Image') ?>
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
                                <?php
                                if (!$updatedSuccessfully) {
                                    echo '<form name="signUpForm" class="mx-1 mx-md-4" method="POST" action="' . htmlspecialchars($_SERVER['PHP_SELF'] . '?photoid=' . $_GET['photoid']) . '">'
                                        . '<input type="hidden" name="delete" value="true">'
                                        . '<div>Are you sure you want to delete "' . $selectedImage['name'] . '"?</div>'
                                        . '<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">'
                                        . '<button type="submit" class="btn btn-primary btn-lg">Delete</button>'
                                        . '</div>'
                                        . '</form>';
                                } else {
                                    echo '
                                    <div style="color: green;">Photo deleted successfully</div>
                                    ';
                                }
                                ?>

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
