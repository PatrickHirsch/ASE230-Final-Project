<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once('db/db.php');



$stmt = $pdo->prepare("SELECT ID, name, email, password, profile_image, status FROM users where ID = ? ");
$updateStmt = $pdo->prepare('UPDATE users SET status = ?, password = ?, name = ?, bio = ? WHERE ID = ?');
$thisUser = getUserObject($pdo, $_SESSION['user_id']);
// $allUsers = getAllUsers($pdo);
$authenticatedUser = $_SESSION['user_id'];
// displaySessionMessage();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt->execute([$authenticatedUser]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($user) {
            // Simple validity checks and update user information
            if ($user['email'] !== $_POST['email']) {
                $errors[] = 'Authentication fail.';
            } else {
                if ($_POST['password'] !== "") {
                    if ($_POST['password'] !== $_POST['passwordRepeat']) {
                        $errors[] = 'validated password does not match';
                    } else {
                        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $updateStmt->execute([$user['status'], $hashedPassword, $_POST['userName'], $_POST['bioName'], $authenticatedUser]);
                    }
                } else {
                    $updateStmt->execute([$user['status'], $user['password'], $_POST['userName'], $_POST['bioName'], $authenticatedUser]);
                }
            }

            // Handle file uploads
            if ($_FILES['profilePhoto']['error'] == 0) {
                $isImage = ['image/jpeg', 'image/png', 'image/gif'];
                //var_dump($isImage);
                if (in_array($_FILES['profilePhoto']['type'], $isImage) && $_FILES['profilePhoto']['size'] <= 2000000) {
                    $filePath = 'data/profilePhotos/' . $user['ID'] . '.' . pathinfo($_FILES['profilePhoto']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $filePath);
                    // Update file path in database if needed
                    $pdo->prepare("UPDATE users SET profile_image = ? WHERE ID = ?")->execute([$filePath, $authenticatedUser]);

                }
            }
        } else {
            if (isset($_SESSION['user_id']))
                $thisUser = getUserObject($pdo, $_SESSION['user_id']);
            else
                header("Location: login.php");
        }
    }
    $_SESSION['success_message'] = 'Your account was successfully updated';
}

?>

<?= echoHeader('Edit User: ', $thisUser['name']) ?>

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
                                    <?php
                                    foreach ($errors as $error) {
                                        echo '<div>'.$error.'</div><br>';
                                    }
                                    ?>

                                    <!-- p name="signUpformDiv" class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up
                                </p -->
                                    <form id="update" name="signUpForm" class="mx-1 mx-md-4" method="POST"

                                        action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                                        enctype="multipart/form-data">


                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="emailInput">Email</label>
                                                <input type="email" id="emailInput" name="email" class="form-control"
                                                    value="<?= $thisUser['email'] ?>" readonly />
                                            </div>
                                        </div>


                                        <div class=" d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="profilePhoto">Profile Photo</label>
                                                <br><img src="<?= getProfilePhoto($pdo, $_SESSION['user_id']) ?>" >
                                                <input type="file" id="profilePhoto" name="profilePhoto"
                                                    class="form-control" />
                                            </div>
                                        </div>


                                        <div class=" d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="nameInput">Name</label>
                                                <input type="text" id="nameInput" name="userName" class="form-control"
                                                    value="<?= $thisUser['name'] ?>" />
                                            </div>
                                        </div>

                                        <div class=" d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="bioInput">Bio</label>
                                                <input type="text" id="bioInput" name="bioName" class="form-control"
                                                    value="<?= $thisUser['bio'] ?>" />
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
                                            <button id="update" type="submit"
                                                class="btn btn-primary btn-lg">Update</button>
                                        </div>
                                    </form>
                                    <div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <a href="removeuser.php"><button id="delete"
                                                    class="btn btn-primary btn-lg">Delete
                                                    Account</button></a>
                                        </div>
                                    </div>
                                </div>
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
