<?php
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete user by ID from the database
    $sqlDelete = "DELETE FROM users WHERE id = $id";
    $conn->query($sqlDelete);

    // Redirect back to users-list.php after deletion
    header('Location: users-list.php');
    exit();
} else {
    // ID not provided, redirect to users-list.php
    header('Location: users-list.php');
    exit();
}
?>
