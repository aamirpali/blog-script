<?php
session_start(); // Start a PHP session
require_once 'header.php'; // Include your header template
require_once 'config.php'; // Include your database configuration

$query = "SELECT p.*, u.username AS author FROM posts p
          INNER JOIN users u ON p.author_id = u.id
          ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Database query error: ' . mysqli_error($conn));
}
echo '<div class="container mt-5">';
echo '<h2>Recent Posts</h2>';

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $author = $row['author'];
        $featured_image = $row['featured_image'];
        $slug = $row['slug'];

        // Output the post as a Bootstrap card
        echo '<div class="card mb-4">';
        echo '<img class="card-img-top post-featured-image" src="../' . $row['featured_image'] . '" alt="' . htmlspecialchars($row['title']) . '">';

        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($title) . '</h5>';
        echo '<a href="post/' . htmlspecialchars($slug) . '.html" class="btn btn-primary">Read More</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="alert alert-info">No posts found.</p>';
}

echo '</div>';

require_once 'footer.php'; // Include your footer template
?>
