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

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Retrieve the post data for editing
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Extract the post data (e.g., title, content, featured_image)
        $title = $row['title'];
        $content = $row['content'];
        $featured_image = $row['featured_image'];

       // Check if form submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get form data
  $title = $_POST['title'];
  $content = $_POST['content'];
  $featured_image = $_FILES['featured_image'];

  // Update database
  $sql = "UPDATE posts SET title='$title', content='$content', featured_image='$featured_image' WHERE id=$post_id";
$title = validate_input($_POST['title']);
$content = sanitize_content($_POST['content']);
  if($conn->query($sql) === TRUE) {
    $msg = "Post updated successfully!";
  } else {
    $msg = "Error updating post: " . $conn->error;
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        tinymce.init({
  selector: '#content' 
});
    </script>
</head>
<body>
    <div class="container">
        <h2>Edit Post</h2>
        <form method="POST" action="edit-post.php" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo $title; ?>" required>
            
            <label for="content">Content:</label>
            <textarea name="content" id="content"><?php echo $content; ?></textarea>

            
            <label for="featured_image">Featured Image:</label>
            <input type="file" name="featured_image" id="featured_image" accept="image/*">
            <?php if (!empty($featured_image)) { ?>
                <img src="../<?php echo $featured_image; ?>" alt="Current Featured Image">
            <?php } ?>

            <input type="submit" value="Save Changes">
        </form>
    </div>
    <script src="https://cdn.tiny.cloud/1/pn2eewkqubpw7ilry9yckz45oeplbrzjlkj43ncdtgyo2rks/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({ 
  selector: '#content' 
});
</script>
</body>
</html>

<?php
    } else {
        echo 'Post not found.';
    }
} else {
    echo 'Post ID not provided.';
}
?>
<?php include 'include/footer.php'; ?>
