<?php
include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteuser'])) {
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
        echo "Delete user ID not specified";
    }
} else {
    echo "Invalid request method";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'updateuser') {
        // Update user information
        if (isset($_POST['updateusers'])) {
            $update_id = $_POST['updateusers'];
            $update_username = $_POST['update_username'];
            $update_password = $_POST['update_password'];
            $update_role = $_POST['update_role'];

            // Handle file upload if a new picture is selected
            if ($_FILES['update_pic']['name']) {
                $targetDirectory = "../assets/img/";
                $update_pic = basename($_FILES['update_pic']['name']);
                $targetPath = $targetDirectory . $update_pic;

                // Perform update query with picture
                $update_query = "UPDATE users SET username='$update_username', password='$update_password', role='$update_role', pic='$update_pic' WHERE user_id='$update_id'";
            } else {
                // Perform update query without updating picture
                $update_query = "UPDATE users SET username='$update_username', password='$update_password', role='$update_role'  WHERE user_id='$update_id'";
            }

            $update_result = $conn->query($update_query);

            if ($update_result) {
                // Move uploaded file to target directory if a new picture is selected
                if ($_FILES['update_pic']['name']) {
                    move_uploaded_file($_FILES['update_pic']['tmp_name'], $targetPath);
                }
                header("location: ../add.php"); // Redirect to the page after a successful update
            } else {
                echo "Error updating user: " . $conn->error;
            }
        } else {
            echo "Update user ID not specified";
        }
    } else {
        echo "Invalid action or action not specified for update";
    }
} else {
    echo "Invalid request method";
}

?>