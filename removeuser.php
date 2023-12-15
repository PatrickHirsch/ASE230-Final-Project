<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once('db/db.php');

$stmt = $pdo->prepare("SELECT status FROM users where ID = ? ");
$thisUser = getUserObject($pdo, $_SESSION['user_id']);

$authenticatedUser = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    //var_dump($password);
    $repeatPassword = $_POST['passwordRepeat'];
    //var_dump($repeatPassword);
    if ($password === $repeatPassword) {
        if (!password_verify($password, $thisUser['password'])) {
            echo 'incorrect password';
        } else {
            $pdo->prepare("UPDATE users SET status = 0 WHERE ID = ?")->execute([$authenticatedUser]);
            $_SESSION['success_message'] = 'Your account has been successfully removed. Please login to restore.';
            header("Location: logout.php");

        }
    }
}
?>
<?= echoHeader('Remove Account: ', $thisUser['name']) ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                                    <form id="update" name="signUpForm" class="mx-1 mx-md-4" method="POST"
                                        action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                                        enctype="multipart/form-data">

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
                                                <label class="form-label" for="passwordInputRepeat">Repeat
                                                    password</label>
                                                <input type="password" id="passwordInputRepeat" name="passwordRepeat"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button id="confirm" type="submit" class="btn btn-primary btn-lg">Delete
                                                Account</button>
                                    </form>



                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <a href="edituser.php"><button id="cancel"  class="btn btn-primary btn-lg"> Cancel
                                            </button></a>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
<?= echoFooter(); ?>