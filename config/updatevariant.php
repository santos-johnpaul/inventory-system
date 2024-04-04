<?php
// Include database connection
include('../config/db.php');

// Check if form is submitted for updating a variant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['variant_id']) && isset($_POST['variant_name'])) {
    // Retrieve variant ID and name from form submission
    $variant_id = $_POST['variant_id'];
    $variant_name = $_POST['variant_name'];

    // Prepare SQL statement to update variant name in the database
    $sql = "UPDATE variant SET variant = ? WHERE variant_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("si", $variant_name, $variant_id);
        $stmt->execute();

        // Redirect back to the same page after successful update
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