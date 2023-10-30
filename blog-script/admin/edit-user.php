<?php
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve user data by ID from the database
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        // User not found, redirect to users-list.php
        header('Location: users-list.php');
        exit();
    }
} else {
    // ID not provided, redirect to users-list.php
    header('Location: users-list.php');
    exit();
}

if (isset($_POST['update'])) {
    // Retrieve and sanitize form input
    $username = $conn->real_escape_string($_POST['username']);
    $age = $conn->real_escape_string($_POST['age']);
    $email = $conn->real_escape_string($_POST['email']);
    $location = $conn->real_escape_string($_POST['location']);

    // Update user data in the database
    $sqlUpdate = "UPDATE users SET username='$username', age='$age', email='$email', location='$location' WHERE id=$id";
    if ($conn->query($sqlUpdate) === TRUE) {
        // Redirect back to users-list.php after update
        header('Location: users-list.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

include 'include/header.php';
?>

<h2>Edit User</h2>

<form method="post">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
    </div>
    <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" class="form-control" id="age" name="age" value="<?php echo $user['age']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" id="location" name="location" value="<?php echo $user['location']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary" name="update">Update User</button>
</form>

<?php include 'include/footer.php'; ?>
