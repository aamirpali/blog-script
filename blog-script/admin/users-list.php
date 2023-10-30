<?php include 'include/header.php'; ?>

<h2>Users List</h2>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
               
                <th>location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../config.php';

            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['username'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['location'] . '</td>';
                    echo '<td>';
                    echo '<a href="edit-user.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit</a> ';
                    echo '<a href="delete-user.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No users found.</td></tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php include 'include/footer.php'; ?>
