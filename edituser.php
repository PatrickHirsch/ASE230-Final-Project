<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';



if($_SERVER['REQUEST_METHOD']==='POST')
{	
	//	echo '<pre>';
	//	var_dump($_FILES['profilePhoto']);
	//	die();
	
	$allUsers=importJSON('data/users.json');
	$authenticatedUser=$_SESSION['user_id'];
	
	for($i=0;$i<count($allUsers);$i++)
	{	if($allUsers[$i]['ID']==$_SESSION['user_id'])
		{	// Simple validity check
			if($allUsers[$i]['email']!=$_POST['email'])
				echo die('Authentication fail.');
			
			// If Password field is not left empty, update password
			if(($_POST['password']!==""))
			{	if(($_POST['password']!==$_POST['passwordRepeat']))
				{	die("Validated password does not match");
				}
				$allUsers[$i]['password']=password_hash($_POST['password'], PASSWORD_BCRYPT);
			}
			
			// Update Name
			if($_POST['userName']!=="") $allUsers[$i]['name']=$_POST['userName'];
			
			// Update Bio
			$allUsers[$i]['bio']=$_POST['bioName'];	
			
			// Update Profile Image
			if($_FILES['profilePhoto']['error']==0)
			{	$isImage=['image/jpeg','image/png','image/gif'];
				if
				(	in_array($_FILES['profilePhoto']['type'],$isImage) &&
					$_FILES['profilePhoto']['size']<=1500000
				)	
					move_uploaded_file($_FILES['profilePhoto']['tmp_name'],getProfilePhoto($allUsers[$i]['ID']));
			}
		}
	}

	writeJSON($allUsers,'data/users.json');
	header("Location: user.php");
	die();
}
else
{	if(isset($_SESSION['user_id'])) $thisUser=getUserObject($_SESSION['user_id']);
	else header("Location: login.php");
}
?>

<?= echoHeader('Edit User: ',$thisUser['name']) ?>
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
                                <form name="signUpForm" class="mx-1 mx-md-4" method="POST"
                                    action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">


                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="emailInput">Email</label>
                                            <input type="email" id="emailInput" name="email" class="form-control" value="<?= $thisUser['email'] ?>" readonly />
                                        </div>
                                    </div>
									
									
                                    <div class=" d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="profilePhoto">Profile Photo</label>
                                            <br><img src="<?= getProfilePhoto($thisUser['ID']) ?>" style="width:100px">
											<input type="file" id="profilePhoto" name="profilePhoto" class="form-control" />
                                        </div>
                                    </div>
									
									
                                    <div class=" d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nameInput">Name</label>
                                            <input type="text" id="nameInput" name="userName" class="form-control" value="<?= $thisUser['name'] ?>"/>
                                        </div>
                                    </div>

                                    <div class=" d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="bioInput">Bio</label>
                                            <input type="text" id="bioInput" name="bioName" class="form-control" value="<?= $thisUser['bio'] ?>"/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="passwordInput">New Password</label>
                                            <input type="password" id="passwordInput" name="password"
                                                class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="passwordInputRepeat">Repeat new
                                                password</label>
                                            <input type="password" id="passwordInputRepeat" name="passwordRepeat"
                                                class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
                                    </div>

                                </form>
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