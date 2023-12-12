<?php
require_once 'include/header.php';
require_once '../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is not logged in, redirect to index.php

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <p>Welcome to the admin panel.</p>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

</body>
</html>
