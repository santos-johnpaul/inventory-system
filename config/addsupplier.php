<?php
// Include database connection
include('../config/db.php');

// Check if form is submitted for adding a new supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supplier_name']) && isset($_POST['contact']) && isset($_POST['address'])) {
    // Retrieve supplier details from form submission
    $supplier_name = $_POST['supplier_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Prepare SQL statement to insert supplier into database
    $sql = "INSERT INTO suppliers (name, contact, address) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("sss", $supplier_name, $contact, $address);
        $stmt->execute();

        // Redirect back to the same page after successful addition
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
