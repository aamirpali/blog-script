<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'config.php';

    $post_id = $_POST['post_id'];
echo "Post ID: $post_id"; // Add this line for debugging$name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    // Prepare the SQL statement with placeholders
   $sql = "INSERT INTO comments (post_id, name, email, content) VALUES (?, ?, ?, ?)";
echo "SQL Query: $sql"; // Add this line for debugging
    
    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters to the placeholders
    mysqli_stmt_bind_param($stmt, 'isss', $post_id, $name, $email, $comment);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: post.php?slug={$post_slug}");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request!";
}

?>