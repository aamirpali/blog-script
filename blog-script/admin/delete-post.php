<?php

// Include config file and header
include '../config.php';
include 'include/header.php'; 

// Check if delete button clicked
if(isset($_GET['id'])) {

  // Get post ID
  $id = $_GET['id'];

  // Delete post query
  $sql = "DELETE FROM posts WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    
    // Show success message
    $msg = "Post deleted successfully";
    
  } else {
    // Show error message
    $msg = "Error deleting post: " . $conn->error;
  }

}

?>

<!-- Show message -->
<div class="col-md-12">
  <?php if(isset($msg)) { ?>
    <p><?=$msg?></p>
  <?php } ?>
</div>

<!-- Add back button -->
<div class="col-md-12">
  <a href="blogs.php" class="btn btn-secondary">Back to Posts</a>
</div>

<?php

// Close connection
$conn->close(); 

// Include footer
include 'include/footer.php';

?>