<?php
// Include database connection
include('../config/db.php');

// Check if form is submitted for updating a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id']) && isset($_POST['category_name']) && isset($_POST['category_type'])) {
    // Retrieve category ID, name, and type from form submission
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $category_type = $_POST['category_type'];

    // Prepare SQL statement to update category in the database
    $sql = "UPDATE category SET category_name = ?, category_type = ? WHERE category_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("ssi", $category_name, $category_type, $category_id);
        $stmt->execute();

        // Redirect back to the same page after successful update
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
