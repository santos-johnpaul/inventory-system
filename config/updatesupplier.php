<?php
// Include database connection
include('../config/db.php');

// Check if form is submitted for updating a supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supplier_id']) && isset($_POST['supplier_name']) && isset($_POST['contact']) && isset($_POST['address'])) {
    // Retrieve supplier details from form submission
    $supplier_id = $_POST['supplier_id'];
    $supplier_name = $_POST['supplier_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Prepare SQL statement to update supplier in the database
    $sql = "UPDATE suppliers SET name = ?, contact = ?, address = ? WHERE supplier_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("sssi", $supplier_name, $contact, $address, $supplier_id);
        $stmt->execute();

        // Redirect back to the same page after successful update
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
