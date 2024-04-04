<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Hash the entered password using MD5
    $hashedEnteredPassword = md5($enteredPassword);

    // Prepare SQL statement to fetch user details based on username
    $sql = "SELECT id, username, password FROM user WHERE username=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user details
            $row = $result->fetch_assoc();
            
            // Verify hashed password using MD5
            if ($hashedEnteredPassword === $row['password']) {
                // Passwords match, set session variables
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];

                // Redirect to dashboard after successful login
                header("Location:../dashboard.php");
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }

        // Close statement
        $stmt->close();
    } else {
        $error = "Error preparing statement: " . $conn->error; // Add error message
    }

    // Close connection
    $conn->close();
}

// Redirect back to the login page with error message
header("Location: ../index.php?error=" . urlencode($error));
exit();
?>