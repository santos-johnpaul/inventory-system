<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"]); // Use MD5 for password hashing (not recommended for security reasons)
    $role = $_POST["role"];

    // Handling file upload
    $targetDirectory = "../assets/img";
    $targetFile = $targetDirectory . basename($_FILES["pic"]["name"]);

    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $targetFile)) {
        // Perform the registration and store the hashed password and role in the database
        $sql = "INSERT INTO users (username, password, role, pic) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $username, $password, $role, $targetFile);
            $stmt->execute();
            header("location: ../add.php");
            // Additional code as needed...

            $stmt->close();
        } else {
            // Handle the case where the statement preparation fails
            $error = "Error preparing statement";
        }

        $conn->close();

        // Redirect or display success/error message as needed
    } else {
        echo "Error uploading the file.";
    }
}
?>
