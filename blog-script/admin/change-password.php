<?php
include 'include/header.php';
require_once '../config.php';
session_start();

if (!isset($_SESSION['admin_username'])) {
    // Redirect to the login page for unauthenticated users.
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = 'New password and confirm password do not match.';
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $adminUsername = $_SESSION['admin_username'];
        $updateQuery = "UPDATE admin SET password = '$hashedPassword' WHERE username = '$adminUsername'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            $message = 'Password changed successfully.';
        } else {
            $error = 'Error changing the password: ' . mysqli_error($conn);
        }
    }
}
?>

<div class="container mt-5">
    <h2>Change Password</h2>
    <?php if (isset($message)) { ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>
    <form method="post">
        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" class="form-control" id="old_password" name="old_password" required>
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>

</body>
</html>
