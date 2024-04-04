<?php
// Database connection
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['variant_name'])) {
    // Retrieve variant name from form submission
    $variant_name = $_POST['variant_name'];

    // Prepare SQL statement to insert variant into database
    $sql = "INSERT INTO variant (variant) VALUES (?)"; // Assuming 'variant_name' is the column name
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter and execute query
        $stmt->bind_param("s", $variant_name);
        $stmt->execute();

        // Check if insertion was successful
        if ($stmt->affected_rows > 0) {
            // Redirect back to the same page after successful addition
            header("Location: ../add_variant.php");
            exit();
        } else {
            // Redirect back to the same page if failed to add variant
            header("Location: ../add_variant.php");
            exit();
        }

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