<?php
session_start();
require_once('../config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <?php
        // Check if the user is logged in
        $loggedIn = isset($_SESSION['user_id']); // Assuming you set a 'user_id' session variable upon successful login

        if ($loggedIn) {
            // If the user is logged in, show the navigation items for the logged-in user
            echo '<ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="users-list.php">Users List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blogs.php">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="smm.php">SMM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="design.php">Design</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change-password.php">Change Password</a>
                    </li>
                <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>';
        } else {
            // If the user is not logged in, show the navigation items for the guest user
            echo '<ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Login</a>
                    </li>
                    
                </ul>';
        }
        ?>
    </div>
</nav>

<div class="container mt-3">
