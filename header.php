<?php
require_once './db/db.php';
function echoHeader($title='',$subtitle='')
{	$ret=echoHead($title,$subtitle).'
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">MyPhotoVault</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="uploadImage.php">Upload</a></li>';

	if(isset($_SESSION['user_status']))
  {
		if($_SESSION['user_status']==3)
      $ret=$ret.'<li class="nav-item"><a class="nav-link" href="admin.php">Admin Dashboard</a></li>';
  }
	$ret=$ret.'
                    </ul>';
	
	if(isset($_SESSION['user_id']))
		$ret=$ret.'<a href="logout.php" class="text-muted"><button class="btn btn-outline-dark" type="submit">Logout</button></a>&nbsp;';
	
	$ret=$ret.'
                    <form class="d-flex"';
	
	if(isset($_SESSION['user_id']))
		$ret=$ret.'action="user.php"';
	else
		$ret=$ret.'action="login.php"';
	
	$ret=$ret.'>
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi bi-person-circle"></i>';
	
	if(isset($_SESSION['user_id']))
		$ret=$ret.$_SESSION['user_name'];
	else
		$ret=$ret.'Login';
	
	$ret=$ret.'
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">'.$title.'</h1>
                    <p class="lead fw-normal text-white-50 mb-0">'.$subtitle.'</p>
                </div>
            </div>
        </header>
';

	return $ret;
}

function echoFooter()
{	echo '
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
';
}

function echoHead($title='',$subtitle='')
{	return '
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>'.$title.' - MyPhotoVault</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
';
}
?>
