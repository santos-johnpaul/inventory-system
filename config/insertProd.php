<?php
include("db.php");

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];

    // Use a transaction to ensure atomic delete
    $conn->begin_transaction();

    try {
        // Assuming Products table (delete first due to foreign key constraint)
        $sqlProducts = "DELETE FROM Products WHERE PDID = $id";
        if ($conn->query($sqlProducts) !== TRUE) {
            throw new Exception("Error deleting from Products table: " . $conn->error);
        }

        // Assuming ProductDetails table
        $sqlProductDetails = "DELETE FROM ProductDetails WHERE PDID = $id";
        if ($conn->query($sqlProductDetails) !== TRUE) {
            throw new Exception("Error deleting from ProductDetails table: " . $conn->error);
        }

        // Commit the transaction if everything is successful
        $conn->commit();

        // Redirect to success page
        header("Location: ../addProd.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        exit();
    }
}





// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['productID'];
    $productDescription = $_POST['PDDescription'];
    $productName = $_POST['productName'];
    $expiryDate = $_POST['expiryDate'];
    $categoryName = $_POST['category'];
    $srp = $_POST['srp'];
    $vat = $_POST['vat'];
    $lossItem = $_POST['lossItem'];
    $defect = $_POST['defect'];
    $refund = $_POST['Refund'];
    $quantity = $_POST['quantity'];

    // Use a transaction to ensure atomic updates
    $conn->begin_transaction();

    try {
        // Check if the record exists before updating
        $checkQuery = "SELECT ProductID FROM Products WHERE ProductID = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows == 0) {
            throw new Exception("Product with ID $id not found.");
        }

        // Update Products table
        $updateProductsQuery = "UPDATE Products 
                                SET ProductName=?,  
                                    CategoryID=(SELECT CategoryID FROM Category WHERE CategoryName=?)
                                WHERE ProductID=?";
        $stmtProducts = $conn->prepare($updateProductsQuery);
        $stmtProducts->bind_param("ssi", $productName, $categoryName, $id);

        // Fetch CategoryID
        $categoryIDQuery = "SELECT CategoryID FROM Category WHERE CategoryName=?";
        $stmtCategoryID = $conn->prepare($categoryIDQuery);
        $stmtCategoryID->bind_param("s", $categoryName);
        $stmtCategoryID->execute();
        $categoryIDResult = $stmtCategoryID->get_result();

        if ($categoryIDResult->num_rows > 0) {
            $categoryIDRow = $categoryIDResult->fetch_assoc();
            $categoryID = $categoryIDRow['CategoryID'];
        } else {
            // Handle the case where the category doesn't exist
            throw new Exception("Category not found.");
        }

        if ($stmtProducts->execute() !== TRUE) {
            throw new Exception("Error updating Products table: " . $stmtProducts->error);
        }

        $stmtProducts->close();
        $stmtCategoryID->close();

        // Update ProductDetails table
        $updateProductDetailsQuery = "UPDATE ProductDetails 
                                      SET ExpiryDate=?, 
                                          SRP=?, 
                                          VAT=?, 
                                          LossItem=?, 
                                          Defect=?, 
                                          Refund=?, 
                                          Quantity=?
                                      WHERE PDID=?";
        $stmtProductDetails = $conn->prepare($updateProductDetailsQuery);
        $stmtProductDetails->bind_param("ddiiiiii", $expiryDate, $srp, $vat, $lossItem, $defect, $refund, $quantity, $id);

        if ($stmtProductDetails->execute() !== TRUE) {
            throw new Exception("Error updating ProductDetails table: " . $stmtProductDetails->error);
        }

        $stmtProductDetails->close();

        // Update Category table
        $updateCategoryQuery = "UPDATE Category 
                               SET CategoryName=?
                               WHERE CategoryID=?";
        $stmtCategory = $conn->prepare($updateCategoryQuery);
        $stmtCategory->bind_param("si", $categoryName, $categoryID);

        if ($stmtCategory->execute() !== TRUE) {
            throw new Exception("Error updating Category table: " . $stmtCategory->error);
        }

        $stmtCategory->close();

        // Commit the transaction if everything is successful
        $conn->commit();

        // Redirect to success page or display a success message
        header("Location: ../addProd.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        exit();
    }
}


if (isset($_POST['add'])) {
    try {
        // Sanitize and validate input (consider using more validation)
        $productName = $_POST['newProductName'];
        $productDescription = $_POST['newPDDescription'];
        $expiryDate = $_POST['newExpiryDate'];
        $categoryName = $_POST['newCategoryName'];
        $srp = $_POST['newSRP'];
        $vat = $_POST['newVAT'];
        $lossItem = $_POST['newLossItem'];
        $defect = $_POST['newDefect'];
        $refund = $_POST['newRefund'];
        $quantity = $_POST['newQuantity'];

        // Use prepared statement for inserting into Category
        $sqlCategory = $conn->prepare("INSERT IGNORE INTO Category (CategoryName) VALUES (?)");
        $sqlCategory->bind_param("s", $categoryName);
        $sqlCategory->execute();
        $sqlCategory->close();

        // Get the CategoryID
        $result = $conn->query("SELECT CategoryID FROM Category WHERE CategoryName = '$categoryName'");
        $row = $result->fetch_assoc();
        $categoryID = $row['CategoryID'];

        // Use prepared statement for inserting into Products
        $sqlProducts = $conn->prepare("INSERT INTO Products (ProductName, CategoryID) VALUES (?, ?)");
        $sqlProducts->bind_param("si", $productName, $categoryID);
        $sqlProducts->execute();
        $sqlProducts->close();

        // Get the last inserted ProductID
        $lastProductID = $conn->insert_id;

        // Use prepared statement for inserting into ProductDetails
        $sqlProductDetails = $conn->prepare("INSERT INTO ProductDetails (PDID, PDDescription, ExpiryDate, SRP, VAT, LossItem, Defect, Refund, Quantity) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sqlProductDetails->bind_param("isssddddd", $lastProductID, $productDescription, $expiryDate, $srp, $vat, $lossItem, $defect, $refund, $quantity);
        $sqlProductDetails->execute();
        $sqlProductDetails->close();

        // Update Products with PDID and CategoryID
        $sqlUpdateProducts = $conn->prepare("UPDATE Products SET PDID = ? WHERE ProductID = ? AND CategoryID = ?");
        $sqlUpdateProducts->bind_param("iii", $lastProductID, $lastProductID, $categoryID);
        $sqlUpdateProducts->execute();
        $sqlUpdateProducts->close();

        // Redirect to success page
        header("Location: ../addProd.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}



?>
