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

function slugify($text)
{
    // Replace non-alphanumeric characters with hyphens
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // Transliterate characters to ASCII
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Remove characters that are not letters, numbers, or hyphens
    $text = preg_replace('~[^-\w]+~', '', $text);

    // Trim hyphens from the beginning and end of the string
    $text = trim($text, '-');

    // Convert the slug to lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

// Define variables to store form data and errors
$title = $content = $featured_image = $slug = $author_id = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission

    // Validate form data
    if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['author_id'])) {
        $error = 'Title, content, and author are required fields.';
    } else {
        // Sanitize input
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $slug = slugify($title); // Use the slugify() function to generate the slug
        $author_id = mysqli_real_escape_string($conn, $_POST['author_id']);

        // Upload and move the featured image to the media folder
        $upload_dir = '../media/';
        $file_name = $_FILES['featured_image']['name'];
        $file_tmp = $_FILES['featured_image']['tmp_name'];
        move_uploaded_file($file_tmp, $upload_dir . $file_name);
        $featured_image = 'media/' . $file_name;

        // Insert the post into the 'posts' table
        $query = "INSERT INTO posts (title, content, featured_image, slug, author_id) VALUES ('$title', '$content', '$featured_image', '$slug', '$author_id')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Post added successfully
            header('Location: blogs.php'); // Redirect to the blog list page
            exit();
        } else {
            $error = 'An error occurred while adding the post.';
        }
    }
}

// Function to retrieve the list of users and their IDs
function getUsersList($conn)
{
    $usersList = array();
    $sql = "SELECT id, username FROM users";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $usersList[$row['id']] = $row['username'];
        }
    }

    return $usersList;
}

$usersList = getUsersList($conn);
?>

<div class="container">
    <h2>Create a New Post</h2>
    <?php if (!empty($error)) { ?>
        <p class="alert alert-danger"><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" id="content" rows="4" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="author_id">Author:</label>
            <select name="author_id" id="author_id" class="form-control" required>
                <option value="">Select an author</option>
                <?php
                foreach ($usersList as $userId => $username) {
                    echo "<option value=\"$userId\">$username</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="featured_image">Featured Image:</label>
            <input type="file" name="featured_image" id="featured_image" accept="image/*" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Create Post" class="btn btn-primary">
        </div>
    </form>
</div>

<?php require_once 'include/footer.php'; ?>
