<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once 'db/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (count($_POST) > 0) {
        // Checking for completeness
        if (
            !isset($_POST['userName'][0]) ||
            !isset($_POST['email'][0]) ||
            !isset($_POST['password'][0])
        ) {
          $errors[] = 'Please fill all fields for sign up.';
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }

            if ($_POST['password'] !== $_POST['passwordRepeat']) {
                $errors[] = 'Validated password does not match.';
            }

            // Check for duplicate email or username
            $duplicateStmt = $pdo->prepare(
                'SELECT ID from users WHERE email = ? OR name = ?;'
            );
            $duplicateStmt->execute(
                [$_POST['email'], $_POST['userName']]
            );
            
            if ($duplicateStmt->rowCount() > 0) {
                $errors[] = 'An account with this email or username already exists.';
            } else {
                // If all checks pass, proceed to save the user data
                $uniqueId = mt_rand() . time();
                $preparedQuery = $pdo->prepare(
                    'INSERT INTO users (name, email, password, date_joined, status) VALUES (?, ?, ?, current_timestamp(), 1)'
                );
                $preparedQuery->execute(
                    [$_POST['userName'], $_POST['email'], password_hash($_POST['password'], PASSWORD_BCRYPT)]
                );
                
                session_start(); 
                $_SESSION['success_message'] = 'Your account has been successfully created. Please login.';
                header('Location: login.php');
            }
        }
    } else {
        $errors[] = 'Please fill all fields for sign up.';
    }
}

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

                                <?= echoErrors($errors); ?>

                                <!-- p name="signUpformDiv" class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up
                                </p -->
                                <form name="signUpForm" class="mx-1 mx-md-4" method="POST"
                                    action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

                                    <div class=" d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nameInput">Your Username</label>
                                            <input type="text" id="nameInput" name="userName" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="emailInput">Your Email</label>
                                            <input type="email" id="emailInput" name="email" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="passwordInput">Password</label>
                                            <input type="password" id="passwordInput" name="password"
                                                class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="passwordInputRepeat">Repeat your
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
