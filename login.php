<?php
session_start();
require_once 'header.php';
require_once 'lib/functions.php';
require_once 'db/db.php';

// Check if the success parameter is present in the URL
if (isset($_SESSION['success_message'])) {
    echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
    unset($_SESSION['success_message']); // Clear the session variable
}
// Check if the user is already logged in and redirect them to user.php
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    header('Location: user.php');
    exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Check if email and password are set
  if (!isset($_POST['email']) || !isset($_POST['password'])) {
      $errors[] = 'Email and password are required.';
  } else {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT ID, name, email, password, status FROM users WHERE email = ?'); 
    $stmt->execute([$email]);
    if ($stmt->rowCount() === 0) {
      $errors[] = $email . ' was not found in our system';
    }
    else {
      $userData = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!password_verify($password, $userData['password'])) {
        $errors[] = 'incorrect password';
      } 
      else {
          $_SESSION['email'] = $userData['email'];
          $_SESSION['user_name'] = $userData['name'];
          $_SESSION['user_id'] = $userData['ID'];
          $_SESSION['user_status'] = $userData['status'];


          if ($_SESSION['user_status'] == 0) {
              $errors[] = "Your account has been deleted. Would you like to restore your account?<br>
              <form method=\"POST\" action=\"\">
              <input type=\"hidden\" name=\"email\" value=\"$email\">
                  <input type=\"hidden\" name=\"password\" value=\"$password\">
                  <button name=\"restore\" type=\"submit\">Restore Account</button></form>";
          }
          else if ($_SESSION['user_status'] == -1) {
              $errors[] = 'Your account has been removed by admin.';
          }
          else {
            // Redirect to user.php
            header('Location: user.php');
            exit();
          }


      }
    }
  }
}
?>
<?= echoHeader('User Login') ?>
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
                                    <?= echoErrors($errors); ?>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example1">Email address</label>
                                            <input type="email" id="form2Example1" name='email' class="form-control" />
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example2">Password</label>
                                            <input type="password" id="form2Example2" name='password'
                                                class="form-control" />
                                        </div>

                                        <!-- 2 column grid layout for inline styling -->
                                        <div class="row mb-4">
                                            <div class="col d-flex justify-content-center">
                                                <!-- Checkbox
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="form2Example31" checked />
                                                    <label class="form-check-label" for="form2Example31"> Remember me
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col">-->
                                                <!-- Simple link -->
                                                <!-- a href="#!">Forgot password?</a> -->
                                            </div>
                                        </div>

                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                                        <!-- Register buttons -->
                                        <div class="text-center">
                                            <p>Not a member? <a href="signup.php">Register</a></p>
                                        </div>
                                    </form>

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
