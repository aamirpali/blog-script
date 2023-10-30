<?php
require_once 'header.php'; // Include your header template
require_once 'config.php'; // Include your database configuration

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT username, email FROM users WHERE id = $user_id";
    $user_result = mysqli_query($conn, $user_query);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
        $username = $user_data['username'];
        $email = $user_data['email'];
    }
}

if (isset($_GET['slug'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['slug']);

    // Retrieve the post by slug
    $query = "SELECT p.*, u.username AS author FROM posts p
              INNER JOIN users u ON p.author_id = u.id
              WHERE p.slug = '$slug'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $content = $row['content'];
        $author = $row['author'];
        $featured_image = $row['featured_image'];
        $date = date('F j, Y', strtotime($row['created_at']));

        // Output the post content
        echo '<div class="container mt-5">';
        echo '<h2>' . htmlspecialchars($title) . '</h2>';
        echo '<p>By ' . htmlspecialchars($author) . '</p>';
        echo '<p>on ' . $date . '</p>';
        echo '<div class="mb-4"><img src="../' . htmlspecialchars($featured_image) . '" class="img-fluid" alt="Featured Image"></div>';
        echo '<div>' . nl2br(htmlspecialchars($content)) . '</div>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5">';
        echo '<p class="alert alert-danger">Post not found.</p>';
        echo '</div>';
    }
} else {
    echo '<div class="container mt-5">';
    echo '<p class="alert alert-danger">Invalid request.</p>';
    echo '</div>';
}

// Show the comment box if the user is logged in
if (isset($username) && isset($email)) {
    echo '<div class="container mt-5">';
    echo '<div class="row">';
    echo '<div class="col-md-8 mx-auto">';
    echo "<h3>Leave a Comment</h3>";
    echo "<form action='submit_comment.php' method='POST'>";
    echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";

    echo "<div class='form-group'>";
    echo "";
    echo "<input type='hidden' name='name' class='form-control' value='$username'>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "";
    echo "<input type='hidden' name='email' class='form-control' value='$email' readonly>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label>Comment:</label>";
    echo "<textarea name='comment' class='form-control'></textarea>";
    echo "</div>";

    echo "<button type='submit' class='btn btn-primary'>Submit</button>";
    echo "</form>";
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// Fetch and display comments
$commentsQuery = "SELECT * FROM comments WHERE post_id = " . mysqli_real_escape_string($conn, $row['id']);
$comments = mysqli_query($conn, $commentsQuery);

if ($comments === false) {
    // Handle the SQL error here
    echo '<div class="container mt-5">';
    echo '<p class="alert alert-danger">Error fetching comments: ' . mysqli_error($conn) . '</p>';
    echo '</div>';
} elseif (mysqli_num_rows($comments) > 0) {
    echo '<div class="container mt-5">';
    echo '<h3>Comments</h3>';
    while ($comment = mysqli_fetch_assoc($comments)) {
        echo '<div class="comment">';
        echo "<p><a href='../user/{$comment['name']}'>" . htmlspecialchars($comment['name']) . "</a>: {$comment['content']}</p>";
        echo "<p>On {$comment['created_at']}</p>";
        echo '</div>';
    }
    echo '</div>';
}

require_once 'footer.php';
