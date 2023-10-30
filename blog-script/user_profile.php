<?php
require_once 'header.php'; // Include your header template
require_once 'config.php'; // Include your database configuration

// Check if a user is logged in (adjust this condition based on your authentication mechanism)
if (isset($_SESSION['username'])) {
    $logged_in_username = $_SESSION['username'];

    if (isset($_GET['username'])) {
        $username = mysqli_real_escape_string($conn, $_GET['username']);

        // Retrieve user information
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $display_username = $user_data['username'];
            $gender = $user_data['gender'];
            $age = $user_data['age'];
            $profile_picture = $user_data['profile_picture'];
            $cover_picture = $user_data['cover_picture'];
            $location = $user_data['location'];
            $bio = $user_data['bio'];
            ?>

        <div class="container mt-5 profile-container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Cover Picture -->
            <img src="../c/<?php echo $cover_picture; ?>" alt="Cover Picture" class="img-fluid cover-image">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-picture-container">
                <!-- Profile Picture with Circular Border -->
                <img src="../i/<?php echo $profile_picture; ?>" class="img-fluid profile-picture" alt="Profile Picture">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-details">
                <h2 class="mt-3"><?php echo $display_username; ?></h2>
                <p class="text-muted"><?php echo $location; ?></p>
                <p><strong>Gender:</strong> <?php echo $gender; ?></p>
                <p><strong>Age:</strong> <?php echo $age; ?></p>
                <p><strong>Bio:</strong> <?php echo $bio; ?></p>
                <!-- Show "Edit Profile" link only if the logged-in user's username matches -->
                <?php if ($logged_in_username === $display_username) : ?>
                    <a href="../edit_profile" class="btn btn-primary btn-edit-profile">Edit Profile</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


            <!-- Display user's posts (centered) -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php
                        $query = "SELECT * FROM posts WHERE author_id = '{$user_data['id']}' ORDER BY created_at DESC";
                        $posts_result = mysqli_query($conn, $query);

                        if ($posts_result && mysqli_num_rows($posts_result) > 0) {
                            echo '<h3>User Posts</h3>';
                            while ($post_row = mysqli_fetch_assoc($posts_result)) {
                                // Display each post here
                                echo '<div class="card mb-4">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($post_row['title']) . '</h5>';
                                echo '<img class="card-img-top post-featured-image" src="../' . htmlspecialchars($post_row['featured_image']) . '" alt="' . htmlspecialchars($post_row['title']) . '">';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<h3>You haven\'t posted anything yet.</h3>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
        } else {
            echo '<div class="container mt-5">';
            echo '<p class="alert alert-danger">User not found.</p>';
            echo '</div>';
        }
    } else {
        echo '<div class="container mt-5">';
        echo '<p class="alert alert-danger">Invalid request.</p>';
        echo '</div>';
    }
} else {
    echo '<div class="container mt-5">';
    echo '<p class="alert alert-warning">You are not logged in.</p>';
    echo '</div>';
}

require_once 'footer.php'; // Include your footer template
?>
