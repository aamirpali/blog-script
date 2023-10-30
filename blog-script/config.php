<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'database_username');
define('DB_PASSWORD', 'database_password');
define('DB_NAME', 'database_name');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
