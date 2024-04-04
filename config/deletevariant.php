<?php
// Include database connection
include('../config/db.php');

// Check if the request is for deleting a variant
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    // Retrieve variant ID from the URL parameter
    $variant_id = $_GET['delete'];

    // Prepare SQL statement to delete variant from the database
    $sql = "DELETE FROM variant WHERE variant_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter and execute query
        $stmt->bind_param("i", $variant_id);
        $stmt->execute();

        // Redirect back to the same page after deletion
        header("Location: ../add_variant.php");
        exit();

        // Close statement
        $stmt->close();
    } else {
        // Redirect back to the same page if error preparing statement
        header("Location: ../add_variant.php");
        exit();
    }
}

// Close connection
$conn->close();
?>
