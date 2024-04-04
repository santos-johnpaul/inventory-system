<?php
// Include database connection
include('../config/db.php');

// Check if form is submitted for adding a new category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name']) && isset($_POST['category_type'])) {
    // Retrieve category name and type from form submission
    $category_name = $_POST['category_name'];
    $category_type = $_POST['category_type'];

    // Prepare SQL statement to insert category into database
    $sql = "INSERT INTO category (category_name, category_type) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("ss", $category_name, $category_type);
        $stmt->execute();

        // Redirect back to the same page after successful addition
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
