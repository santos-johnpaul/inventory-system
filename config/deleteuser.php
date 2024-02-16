<?php
include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteuser'])) {
        // Delete user
        $delete_user_id = $_POST['deleteuser'];

        // Perform delete query
        $delete_query = "DELETE FROM users WHERE user_id='$delete_user_id'";
        $delete_result = $conn->query($delete_query);

        if ($delete_result) {
            header("location: ../add.php");
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
?>
