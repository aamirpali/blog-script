<?php
require_once 'header.php'; // Include your header template
require_once 'config.php'; // Include your database configuration

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve the user's current information
    $getUserQuery = "SELECT * FROM users WHERE id = $user_id";
    $getUserResult = mysqli_query($conn, $getUserQuery);

    if ($getUserResult && mysqli_num_rows($getUserResult) > 0) {
        $userData = mysqli_fetch_assoc($getUserResult);
        $currentUsername = $userData['username'];
        $currentEmail = $userData['email'];
        $currentAge = $userData['age']; // Assuming it's stored as a varchar
        $currentGender = $userData['gender'];
        $currentLocation = $userData['location'];
        $currentBio = $userData['bio'];
        $currentProfilePicture = $userData['profile_picture'];
        $currentCoverPicture = $userData['cover_picture'];

        // Handle form submission when the user clicks the "Save Changes" button
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize user inputs
            $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
            $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
            $newAge = mysqli_real_escape_string($conn, $_POST['age']); // Updated to use age directly
            $newGender = mysqli_real_escape_string($conn, $_POST['gender']);
            $newLocation = mysqli_real_escape_string($conn, $_POST['location']);
            $newBio = mysqli_real_escape_string($conn, $_POST['bio']);

            // Initialize variables to store the new file names
            $newProfilePictureFileName = $currentProfilePicture;
            $newCoverPictureFileName = $currentCoverPicture;

            // Handle profile picture upload
            if (!empty($_FILES['profile_picture']['name'])) {
                $profilePictureUploadDir = 'uploads/';
                $profilePictureFileName = $_FILES['profile_picture']['name'];
                $newProfilePictureFileName = generateFileName($profilePictureUploadDir, $profilePictureFileName);

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePictureUploadDir . $newProfilePictureFileName)) {
                    // Profile picture uploaded successfully
                } else {
                    // Handle the profile picture upload error
                    echo '<div class="container mt-5">';
                    echo '<p class="alert alert-danger">Error uploading profile picture.</p>';
                    echo '</div>';
                }
            }

            // Handle cover picture upload
            if (!empty($_FILES['cover_picture']['name'])) {
                $coverPictureUploadDir = 'uploads/cover_pictures/';
                $coverPictureFileName = $_FILES['cover_picture']['name'];
                $newCoverPictureFileName = generateFileName($coverPictureUploadDir, $coverPictureFileName);

                if (move_uploaded_file($_FILES['cover_picture']['tmp_name'], $coverPictureUploadDir . $newCoverPictureFileName)) {
                    // Cover picture uploaded successfully
                } else {
                    // Handle the cover picture upload error
                    echo '<div class="container mt-5">';
                    echo '<p class="alert alert-danger">Error uploading cover picture.</p>';
                    echo '</div>';
                }
            }

            // Check if form details have changed
            if (
                $newUsername !== $currentUsername ||
                $newEmail !== $currentEmail ||
                $newAge !== $currentAge ||
                $newGender !== $currentGender ||
                $newLocation !== $currentLocation ||
                $newBio !== $currentBio ||
                $newProfilePictureFileName !== $currentProfilePicture ||
                $newCoverPictureFileName !== $currentCoverPicture
            ) {
                // Update user information in the database
                $updateQuery = "UPDATE users SET
                    username = '$newUsername',
                    email = '$newEmail',
                    age = '$newAge',  -- Update age field
                    gender = '$newGender',
                    location = '$newLocation',
                    bio = '$newBio',
                    profile_picture = '$newProfilePictureFileName',  -- Update profile picture field
                    cover_picture = '$newCoverPictureFileName'    -- Update cover picture field
                    WHERE id = $user_id";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    // Successful update
                    header('Location: ../user/' . $_SESSION['username']);
                    exit();
                } else {
                    // Handle the update error
                    echo '<div class="container mt-5">';
                    echo '<p class="alert alert-danger">Error updating profile: ' . mysqli_error($conn) . '</p>';
                    echo '</div>';
                }
            } else {
                // No changes made, display a message
                echo '<div class="container mt-5">';
                echo '<p class="alert alert-info">No changes were made to your profile.</p>';
                echo '</div>';
            }
        }

        // Display the edit profile form with Twitter-like styling
        echo '<div class="container mt-5">';
        echo '<h2>Edit Profile</h2>';
        echo '<div class="container mt-5">';
        echo '</div>';
        echo '<form method="POST" enctype="multipart/form-data">';
        
        // Profile Picture
        echo '<div class="form-group">';
        echo '<label for="profile_picture">Profile Picture:</label>';
        echo '<div class="profile-picture-container">';
      if (!empty($currentProfilePicture)) {
    echo '<img src="../uploads/' . htmlspecialchars($currentProfilePicture) . '" alt="Profile Picture" width="200" height="200">';
} else {
    echo '<img src="../uploads/default_avatar.png" alt="Default Profile Picture" width="200" height="200">';
}
        echo '</div>';
        echo '<input type="file" class="form-control-file" id="profile_picture" name="profile_picture">';
        echo '</div>';
        
        // Cover Picture
        echo '<div class="form-group">';
        echo '<label for="cover_picture">Cover Picture:</label>';
        echo '<div class="cover-picture-container">';
        if (!empty($currentCoverPicture)) {
            echo '<img src="../uploads/cover_pictures/' . htmlspecialchars($currentCoverPicture) . '" alt="Cover Picture" width="450" height="200">';
        } else {
            echo '<img src="../uploads/cover_pictures/default_cover.jpg" alt="Default Cover Picture">';
        }
        echo '</div>';
        echo '<input type="file" class="form-control-file" id="cover_picture" name="cover_picture">';
        echo '</div>';
        
        // Other fields
        echo '<div class="form-group">';
        echo '<label for="username">Username:</label>';
        echo '<input type="text" class="form-control" id="username" name="username" value="' . htmlspecialchars($currentUsername) . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="email">Email:</label>';
        echo '<input type="email" class="form-control" id="email" name="email" value="' . htmlspecialchars($currentEmail) . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="age">Age:</label>';
        echo '<input type="text" class="form-control" id="age" name="age" value="' . htmlspecialchars($currentAge) . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="gender">Gender:</label>';
        echo '<select class="form-control" id="gender" name="gender">';
        echo '<option value="female" ' . ($currentGender === 'female' ? 'selected' : '') . '>Female</option>';
        echo '<option value="male" ' . ($currentGender === 'male' ? 'selected' : '') . '>Male</option>';
        echo '</select>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="location">Location:</label>';
        echo '<input type="text" class="form-control" id="location" name="location" value="' . htmlspecialchars($currentLocation) . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="description">Bio (500 characters max):</label>';
        echo '<textarea class="form-control" id="bio" name="bio" rows="5" maxlength="500">' . htmlspecialchars($currentBio) . '</textarea>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Save Changes</button>';
        echo '</form>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5">';
        echo '<p class="alert alert-danger">User not found.</p>';
        echo '</div>';
    }
} else {
    echo '<div class="container mt-5">';
    echo '<p class="alert alert-danger">Please log in to edit your profile.</p>';
    echo '</div>';
}

// Function to generate a random 10-digit file name
function generateFileName($directory, $originalFileName) {
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $randomFileName = rand(10000, 99999) . '_' . rand(10000, 99999) . '.' . $extension;
    while (file_exists($directory . $randomFileName)) {
        $randomFileName = rand(10000, 99999) . '_' . rand(10000, 99999) . '.' . $extension;
    }
    return $randomFileName;
}
echo '<div class="container mt-5">';
echo '</div>';
require_once 'footer.php'; // Include your footer template
?>