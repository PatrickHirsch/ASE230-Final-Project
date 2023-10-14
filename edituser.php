<?php
//This page allows a user to edit their own profile page (password,  name,  bio, ect)
session_start();
require_once 'header.php';
require_once 'lib/functions.php';

if($_SERVER['REQUEST_METHOD']==='POST')
{	
	$allUsers=importJSON('data/users.json');
	$authenticatedUser=$_SESSION['user_id'];
	
	//var_dump(count($_POST));
	
	//
	
			
	
	
	
	
	for($i=0;$i<count($allUsers);$i++)
	{	if($allUsers[$i]['ID']==$_SESSION['user_id'])
		{	//echo '<pre>';
			//var_dump($i);
			//echo '</pre><hr>';
			
			// Simple validity check
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
			if($_POST['userName']!=="")
			{	$allUsers[$i]['name']=$_POST['userName'];
			}
			
			// Update Bio
			$allUsers[$i]['bio']=$_POST['bioName'];	
		}
	}
	
	//echo '<pre>';
	//var_dump($allUsers);
	//echo '</pre><hr>';
	//die();
	file_put_contents('data/users.json',json_encode($allUsers,JSON_PRETTY_PRINT));
	header("Location: user.php");
}
else
{	if(isset($_SESSION['user_id'])) $thisUser=getUserObject($_SESSION['user_id']);
	else header("Location: signup.php");
}
//	
//	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//	
//	if (count($_POST) > 0) {
//	    //Checking for completeness
//	    if (isset($_POST['userName'][0]) && isset($_POST['email'][0]) && isset($_POST['password'][0])){
//	        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
//	            die("Please enter valid email");
//	
//	        }
//	    }
//	    if ($_POST['password'] !== $_POST['passwordRepeat']){
//	        die("Validated password does not match");
//	    }
//	    $uniqueId = mt_rand() . time();
//	
//	    // If all checks pass, proceed to save the user data
//	    $userData = [
//	        'ID' => $uniqueId,
//	        'name' => $_POST['userName'],
//	        'email' => $_POST['email'],
//   'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
//	        'dateJoined' => time(),
//	        'bio' => '',
//	        'userProfileImage'=>'',
//	        'AlbumID'=> $uniqueId,
//	        'status' => '1'
//	    ];
//	    var_dump($userData);
//	    $filePath=__DIR__ .'/data/users.json';
//	    //var_dump($filePath);
//	    // Read existing users from users.json, if it exists
//	    $users = [];
//	    if (file_exists($filePath)) {
//	        $users = json_decode(file_get_contents($filePath), true);
//	        //echo "path exist";
//	        // Check if the email already exists in the users.json file
//	        foreach ($users as $user) {
//	            if ($user['email'] === $_POST['email']) {
//	                die('An account with this email already exists.');
//	            }
//	            if ($user['name']=== $_POST['userName']){
//	                die('That username is already in use. Please select another');
//	            }
//	        }
//	
//	        // Add the new user data to the existing users array
//	        $users[] = $userData;
//	
//	        // Save the updated users array back to users.json
//	        file_put_contents($filePath, json_encode($users,JSON_PRETTY_PRINT));
//	
//	        // Optionally, you can redirect the user to a success page
//	        session_start(); // Start the session if not already started
//	        $_SESSION['success_message'] = 'Your account has been successfully created. Please login.';
//	        header('Location: login.php');
//	    }
//	} else {
//	        echo 'Please fill all feilds for sign up.';
//	}
//	
//	}
//	
?>
<?= echoHeader('Sign up') ?>
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
                                    action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">


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
                                            <label class="form-label" for="nameInput">Name</label>
                                            <input type="text" id="nameInput" name="userName" class="form-control" value="<?= $thisUser['name'] ?>"/>
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

                                    <div class=" d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="bioInput">Bio</label>
                                            <input type="text" id="bioInput" name="bioName" class="form-control" value="<?= $thisUser['bio'] ?>"/>
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

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox" value=""
                                            id="form2Example3c" />
                                        <label class="form-check-label" for="form2Example3">
                                            I agree all statements in <a href="#!">Terms of service</a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                    </div>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <a href="login.php">Back to Login</a>
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