<?php
// Include database connection
include('../config/db.php');

// Check if the request is for deleting a supplier
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    // Retrieve supplier ID from the URL parameter
    $supplier_id = $_GET['delete'];

    // Prepare SQL statement to delete supplier from the database
    $sql = "DELETE FROM suppliers WHERE supplier_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter and execute query
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();

        // Redirect back to the same page after deletion
        header("Location: ../add_supplier.php");
        exit();

        // Close statement
        $stmt->close();
    } else {
        // Redirect back to the same page if error preparing statement
        header("Location: ../add_supplier.php");
        exit();
    }
}

// Close connection
$conn->close();
?>
