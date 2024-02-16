<?php
include("db.php");

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $sql = "DELETE FROM PRODUCTS WHERE ProductID=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../addProd.php"); // Redirect to success page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['productID'];
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $expiryDate = $_POST['expiryDate'];
    $category = $_POST['category'];
    $srp = $_POST['srp'];
    $vat = $_POST['vat'];
    $lossItem = $_POST['lossItem'];
    $defect = $_POST['defect'];
    $Refund = $_POST['Refund'];
    
    $sql = "UPDATE PRODUCTS SET ProductName='$productName', ProductDescription='$productDescription', ExpiryDate='$expiryDate', Category='$category', SRP='$srp', VAT='$vat', LossItem=$lossItem, Defect=$defect, Refund=$Refund WHERE ProductID=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../addProd.php"); // Redirect to success page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Insert
if (isset($_POST['add'])) {
    $productName = $_POST['newProductName'];
    $productDescription = $_POST['newProductDescription'];
    $expiryDate = $_POST['newExpiryDate'];
    $category = $_POST['newCategory'];
    $srp = $_POST['newSRP'];
    $vat = $_POST['newVAT'];
    $lossItem = $_POST['newLossItem'];
    $defect = $_POST['newDefect'];
    $Refund = $_POST['newRefund'];
    
    $sql = "INSERT INTO PRODUCTS (ProductName, ProductDescription, ExpiryDate, Category, SRP, VAT, LossItem, Defect, Refund) VALUES ('$productName', '$productDescription', '$expiryDate', '$category', '$srp', '$vat', $lossItem, $defect, $Refund)";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../addProd.php"); // Redirect to success page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
