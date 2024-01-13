<?php
// Define the User class
require_once 'class.php';

// Start a session to persist user data across pages
session_start();

// Check if the 'users' session variable is set
if (isset($_SESSION['users'])) {
    // Retrieve the 'users' array from the session
    $users = $_SESSION['users'];

    // Check if 'id' is set in the session
    if (isset($_SESSION['id']) && isset($users[$_SESSION['id']])) {
        // Retrieve the user object from the 'users' array based on 'id'
        $user = $users[$_SESSION['id']];

        // Check if the 'update' button was clicked
        if (isset($_POST['update'])) {
            if (!empty($_POST['first_name'] && !empty($_POST['last_name']))) {
                $user->set_name($_POST['first_name'] . ' ' . $_POST['last_name']);
            }
            if (!empty($_POST['password'])) {
                // Check password complexity
                if (strlen($_POST['password']) >= 6) {
                    $numCount = preg_match_all("/[0-9]/", $_POST['password']);
                    $letterCount = preg_match_all("/[a-zA-Z]/", $_POST['password']);
                    if ($numCount >= 2 && $letterCount >= 4) {
                        $user->set_password($_POST['password']);
                    }
                }
            }
            if (!empty($_POST['date_of_birth'])) {
                $user->set_date_of_birth($_POST['date_of_birth']);
            }
        }
    } else {
        // Display an error if 'id' is not found in the session
        echo "User ID not found in session.";
    }
} else {
    // Display a message if no user data is found in the session
    echo "Error: Session data not found.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="P_space.css">

</head>

<body>

    <div class="container ms-5 my-5" id="change_info">

        <h1>Change your information</h1>


        <form class="mx-5" action="P_space.php" method="post">
            <div class="row">
                <div class="col-3 my-2">
                    <input type="text" class="form-control" placeholder="write the new first_name" name="first_name">
                </div>
                <div class="col-3 my-2">
                    <input type="text" class="form-control" placeholder="write the new last_name" name="last_name">
                </div>
            </div>
            <div class="row">
                <div class="col-6 mt-2">
                    <input type="email" class="form-control" value="<?php echo $user->get_email() ?>" name="email" disabled>
                    <label for="email" class="form-label">You can't change your email</label>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-1">
                    <input type="text" class="form-control" value="<?php echo $user->get_username() ?>" name="username" disabled>
                    <label for="username" class="form-label">You can't change your username</label>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-2">
                    <input type="password" class="form-control" placeholder="write the new password" name="password">
                    <label for="password" id="password-label" class="form-label">The password must contain at least 6 characters, with at least two of them being numbers and four of them being letters</label>
                </div>
            </div>
            <div class="row">
                <div class="col-6 my-2">
                    <input type="date" class="form-control" value=<?php echo $user->get_date_of_birth() ?> name="date_of_birth">
                </div>
            </div>
            <div class="row">
                <div class="col-6 my-2">
                    <input type="submit" class="btn btn-primary" value="save changes" name="update">
                </div>
            </div>

        </form>

    </div>

    <div class="container ms-5 my-5" id="personal_info">

        <h1>Your profile</h1>

        <span>
            <h4>Name:</h4><?php echo $user->get_name() ?>
        </span>
        <span>
            <h4>Email:</h4><?php echo $user->get_email() ?>
        </span>
        <span>
            <h4>Username:</h4><?php echo $user->get_username() ?>
        </span>
        <span>
            <h4>Password:</h4>*********
        </span>
        <span>
            <h4>Date of birth:</h4><?php echo $user->get_date_of_birth() ?>
        </span>

    </div>
    <!-- Bootstrap and Popper.js scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>