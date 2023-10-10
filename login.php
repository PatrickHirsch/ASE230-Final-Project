<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        //var_dump($email);
        //var_dump($password);
        // Read the user data from the JSON file
        $userData = json_decode(file_get_contents('data/users.json'), true);

        // Loop through user data to find a matching user
        foreach ($userData as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                // Store user data in the session
                $_SESSION['email'] = $email;
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_id']=$user['ID'];
                $_SESSION['user_status']=$user['status'];

                // Redirect to user.php
                header('Location: user.php');
                exit();
            }
        }

        // If no matching user is found, display an error message
        echo 'Invalid email or password. Please try again or Create an account';
    }
}

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                            <input type="email" id="form2Example1" name='email' class="form-control" />
                                            <label class="form-label" for="form2Example1">Email address</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <input type="password" id="form2Example2" name='password'
                                                class="form-control" />
                                            <label class="form-label" for="form2Example2">Password</label>
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
                                                <a href="#!">Forgot password?</a>
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