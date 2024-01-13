<?php
// Define the User class
require_once 'class.php';

// Start a session to persist user data across pages
session_start();

// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Initialize the session variable if it doesn't exist
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }

    // Reference to the session users array
    $users = &$_SESSION['users'];

    // Get username and password from the submitted form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username
    if (empty($username)) {
        $username_error = "Username is required";
    }

    // Validate password
    if (empty($password)) {
        $password_error = "Password is required";
    }

    // If both username and password are provided
    if (!empty($username) && !empty($password)) {
        $match_found = false;

        // Loop through existing users to find a match
        foreach ($users as $userId => $user) {
            if ($user->get_username() == $username && password_verify($password, $user->get_password())) {
                $match_found = true;
                if (str_starts_with($username, "admin")) {
                    // Redirect to admin.php for admin users
                    header("Location: admin.php");
                    exit();
                } else {
                    // Set user ID in session and redirect to P_space.php for regular users
                    $_SESSION['id'] = $user->get_id();
                    header("Location: P_space.php");
                    exit();
                }
            }
        }

        // If no match is found, display an error message
        if (!$match_found) {
            $no_match_error = "Wrong username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <div class="container" id="login">

        <h1 id="login-title">Log In</h1>

        <form class="mx-5 w-50" action="index.php" method="post">
            <div class="row">
                <div class="my-4">
                    <input type="text" class="form-control" name="username" placeholder="username">
                    <?php
                    // Display username error message
                    if (isset($username_error)) {
                        echo '<div class="error-message text-danger">' . $username_error . '</div>';
                    } ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="password" class="form-control" name="password" placeholder="password">
                    <?php
                    // Display password and match error messages
                    if (isset($password_error)) {
                        echo '<div class="error-message text-danger">' . $password_error . '</div>';
                    }
                    if (isset($no_match_error)) {
                        echo '<div class="error-message text-danger">' . $no_match_error . '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div id="button-container">
                    <input type="submit" value="Log In" name="submit" class="btn mb-5" id="button">
                </div>
            </div>
        </form>
    </div>

    <div id="signup-link">

        <h1>Don't have an account ?</h1>

        <p class="mx-5">To have your own personal space you need to create an account first !</p>

        <button class="btn" onclick="location.href='sign_up.php'">Sign up</button>

        <!-- Blob element for decoration -->
        <div class="blob"></div>

    </div>

    <!-- Bootstrap and Popper.js scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>