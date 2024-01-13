<?php
// Define the User class
require_once 'class.php';

// Start a session to persist user data across pages
session_start();

// Check if the 'users' session variable is set
if (!isset($_SESSION['users'])) {
    // If not set, initialize it as an empty array
    $_SESSION['users'] = [];
}

// Reference the 'users' array from the session
$users = &$_SESSION['users'];

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $full_name = $first_name . " " . $last_name;
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $date_of_birth = $_POST['date_of_birth'];

    // Validate first name
    if (empty($first_name)) {
        $first_name_error = "First name is required";
    }

    // Validate last name
    if (empty($last_name)) {
        $last_name_error = "Last name is required";
    }

    // Validate email
    if (empty($email)) {
        $email_error = "Email is required";
    } else {
        // Check email format
        if (!str_ends_with($email, "@gmail.com")) {
            $email_format_error = "Invalid email format";
        }
    }

    // Validate username
    if (empty($username)) {
        $username_error = "Username is required";
    }

    // Validate password
    if (empty($password)) {
        $password_error = "Password is required";
    } else {
        // Check password length
        if (strlen($password) < 6) {
            $password_length_error = "Password must be at least 6 characters";
        } else {
            // Check password complexity
            $numCount = preg_match_all("/[0-9]/", $password);
            $letterCount = preg_match_all("/[a-zA-Z]/", $password);

            if ($numCount < 2) {
                $password_num_error = "Password must contain at least 2 numbers";
            }
            if ($letterCount < 4) {
                $password_letter_error = "Password must contain at least 4 letters";
            }
        }
    }

    // Validate date of birth
    if (empty($date_of_birth)) {
        $date_of_birth_error = "Date of birth is required";
    }

    // Check for existing email and username in the session
    foreach ($users as $userId => $user) {
        if ($user->get_email() == $email) {
            $email_exists_error = "Email already exists";
        }
        if ($user->get_username() == $username) {
            $username_exists_error = "Username already exists";
        }
    }

    // If no validation errors, create a new User object and add it to the session
    if (empty($first_name_error) && empty($last_name_error) && empty($email_error) && empty($email_format_error) && empty($email_exists_error) && empty($username_error) && empty($username_exists_error) && empty($password_error) && empty($password_length_error) && empty($password_num_error) && empty($password_letter_error) && empty($date_of_birth_error)) {

        // Create a new User object with the following parameters:
        $user = new User(uniqid(), $full_name, $email, $username, password_hash($password, PASSWORD_DEFAULT), $date_of_birth);

        // The user's ID is used as the key for easy retrieval.
        $users[$user->get_id()] = $user;

        if (str_starts_with($username, "admin")) {
            header("Location: admin.php");
            exit();
        } else {
            // Set the 'id' in the session to the new user's ID.
            $_SESSION['id'] = $user->get_id();
            // Redirect the user to the 'P_space.php' page after successful registration.
            header("Location: P_space.php");

            // Terminate the script to ensure no further execution after the redirect.
            exit();
        }
    }

    // Clear the session
    //unset($_SESSION['users']);
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
    <link rel="stylesheet" href="sign_up.css">
</head>

<body>

    <div class="container mt-2">

        <h1 id="singin-title">Sign In</h1>

        <form class="mx-5 w-50" action="sign_up.php" method="post">
            <div class="row">
                <div class="col-6 my-4">
                    <input type="text" class="form-control" name="first_name" placeholder="first name">
                    <?php
                    // Display first name error message
                    if (!empty($first_name_error)) {
                        echo '<div class="error-message text-danger">' . $first_name_error . '</div>';
                    }
                    ?>
                </div>
                <div class="col-6 my-4">
                    <input type="text" class="form-control" name="last_name" placeholder="last name">
                    <?php
                    // Display last name error message
                    if (!empty($last_name_error)) {
                        echo '<div class="error-message text-danger">' . $last_name_error . '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="email" class="form-control" name="email" placeholder="email">
                    <?php
                    // Display email error messages
                    if (!empty($email_error)) {
                        echo '<div class="error-message text-danger">' . $email_error . '</div>';
                    }
                    if (!empty($email_format_error)) {
                        echo '<div class="error-message text-danger">' . $email_format_error . '</div>';
                    }
                    if (!empty($email_exists_error)) {
                        echo '<div class="error-message text-danger">' . $email_exists_error . '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="text" class="form-control" name="username" placeholder="username">
                    <?php
                    // Display username error messages
                    if (!empty($username_error)) {
                        echo '<div class="error-message text-danger">' . $username_error . '</div>';
                    }
                    if (!empty($username_exists_error)) {
                        echo '<div class="error-message text-danger">' . $username_exists_error . '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-1">
                    <!-- Input field for password -->
                    <input type="password" class="form-control" name="password" placeholder="password">
                    <?php
                    // Display password error messages
                    if (!empty($password_error)) {
                        echo '<div class="error-message text-danger">' . $password_error . '</div>';
                    }
                    ?>
                    <!-- Password requirements label -->
                    <label for="password" id="password-label" class="form-label">The password must contain at least 6 characters, with at least two of them being numbers and four of them being letters</label>
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="date" class="form-control" name="date_of_birth" placeholder="date of birth">
                    <?php
                    // Display date of birth error message
                    if (!empty($date_of_birth_error)) {
                        echo '<div class="error-message text-danger">' . $date_of_birth_error . '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div id="button-container">
                    <input type="submit" value="Sign In" class="btn mb-5" id="button" name="submit">
                </div>
            </div>
        </form>

    </div>

    <div id="login-link">

        <h1>already have an account ?</h1>

        <p class="mx-5">If you already have an account, you can log in here.</p>

        <button class="btn" onclick="location.href='index.php'">Sign up</button>

        <!-- Blob element for decoration -->
        <div class="blob"></div>

    </div>

</body>

<!-- Bootstrap and Popper.js scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>