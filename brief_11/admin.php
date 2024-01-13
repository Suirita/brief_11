<?php
// Define the User class
require_once 'class.php';

// Start a session to persist user data across pages
session_start();

// Initialize the session variable if it doesn't exist
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    // Get the user ID to be deleted
    $userIdToDelete = $_POST['user_id'];

    // Delete the user from the session variable
    foreach ($_SESSION['users'] as $key => $user) {
        if ($user->get_id() == $userIdToDelete) {
            unset($_SESSION['users'][$key]);
            break;
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
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <h1 class="text-center my-4">Admin Page</h1>

    <a href="index.php" class="btn btn-primary mx-3" id="back-btn">Back to Home</a>

    <table class="table table-striped my-2">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_SESSION['users'] as $user) {
                if (str_starts_with($user->get_username(), 'admin') == false) {
                    echo '<tr>';
                    echo '<td>' . $user->get_id() . '</td>';
                    echo '<td>' . $user->get_name() . '</td>';
                    echo '<td>' . $user->get_email() . '</td>';
                    echo '<td>' . $user->get_username() . '</td>';
                    echo '<td>' . $user->get_password() . '</td>';
                    echo '<td>' . $user->get_date_of_birth() . '</td>';
                    echo '<td>';
                    echo '<form action="admin.php" method="post">';
                    echo '<input type="hidden" name="user_id" value="' . $user->get_id() . '">';
                    echo '<button type="submit" name="delete_user" class="btn btn-danger">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>

</body>

</html>