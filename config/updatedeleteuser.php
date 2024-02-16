<?php
include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_username'])) {
        // Update user information
        $update_username = $_POST['update_username'];
        $update_password = $_POST['update_password'];
        $update_role = $_POST['update_role'];

        // Handle file upload
        $targetDirectory = "../assets/img/";
        $update_pic = basename($_FILES['update_pic']['name']);
        $targetPath = $targetDirectory . $update_pic;

        // Perform update query
        $update_query = "UPDATE users SET password='$update_password', role='$update_role', pic='$update_pic' WHERE username='$update_username'";
        echo "Update Query: $update_query";

        $update_result = $conn->query($update_query);

        if ($update_result) {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['update_pic']['tmp_name'], $targetPath)) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file.";
            }
            header("location: ../add.php");
        } else {
            echo "Error updating user: " . $conn->error;
        }
    } elseif (isset($_POST['delete_username'])) {
        // Delete user
        $delete_username = $_POST['delete_username'];

        // Perform delete query
        $delete_query = "DELETE FROM users WHERE username='$delete_username'";
        $delete_result = $conn->query($delete_query);

        if ($delete_result) {
            echo "User deleted successfully!";
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
