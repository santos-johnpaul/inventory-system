<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"]); // Hash the password using MD5

    // Perform the registration and store the hashed password in the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        // Additional code as needed...

        $stmt->close();
    } else {
        // Handle the case where the statement preparation fails
        $error = "Error preparing statement";
    }

    $conn->close();

    // Redirect or display error message as needed
}
?>
