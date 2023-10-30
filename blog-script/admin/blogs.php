<?php

include 'include/header.php';

session_start();

if (!isset($_SESSION['admin_username'])) {
  // Redirect to login page
  header('Location: index.php');
  exit();
}

?>

<h2>Posts List</h2>

<div class="mb-3">
  <a href="create_post.php" class="btn btn-success">Create Post</a> 
</div>

<div class="table-responsive">

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Featured</th>
        <th>Title</th>
        <th>Author</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
    
<?php

require_once '../config.php';

$sql = "SELECT posts.*, users.username as username FROM posts 
         LEFT JOIN users ON posts.author_id = users.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  while ($row = $result->fetch_assoc()) {

    echo '<tr>';
    echo '<td><img src="../' . $row['featured_image'] . '" alt="Featured Image" width="50"></td>';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>' . $row['username'] . '</td>';
    echo '<td>';
    echo '<a href="edit-post.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit</a> ';
    
    // Add delete button
    echo '<a href="delete-post.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
    
    echo '</td>';
    echo '</tr>';
    
  }
  
} else {
  echo '<tr><td colspan="4">No posts found.</td></tr>';
}

$conn->close();

?>

    </tbody>
  </table>

</div>

<?php include 'include/footer.php'; ?>