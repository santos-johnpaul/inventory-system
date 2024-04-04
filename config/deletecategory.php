<?php
// Include database connection
include('../config/db.php');

// Check if the request is for deleting a category
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    // Retrieve category ID from the URL parameter
    $category_id = $_GET['delete'];

    // Prepare SQL statement to delete category from the database
    $sql = "DELETE FROM category WHERE category_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter and execute query
        $stmt->bind_param("i", $category_id);
        $stmt->execute();

        // Redirect back to the same page after deletion
        header("Location: ../add_category.php");
        exit();

        // Close statement
        $stmt->close();
    } else {
        // Redirect back to the same page if error preparing statement
        header("Location: ../add_category.php");
        exit();
    }
}

// Close connection
$conn->close();
?>
