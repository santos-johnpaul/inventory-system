<?php
// Include the template content
ob_start();
include ('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;

// Additional content specific to the current page goes here
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products Table</title>
<style>
    /* CSS styles for input fields */
    input[type="text"],
    input[type="date"],
    input[type="number"],
    textarea {
        width: auto; /* Set width to auto */
        max-width: 100%; /* Ensure input fields don't overflow their container */
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 14px;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Additional CSS styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    h2 {
        margin: 20px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        vertical-align: top; /* Align content to the top */
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .btn-update, .btn-delete, .btn-add {
        padding: 10px 20px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        color: #fff;
        transition: background-color 0.3s;
        font-size: 14px;
        min-width: 120px;
    }

    .btn-update {
        background-color: #28a745;
        margin-right: 5px;
        margin-bottom: 10px;
    }

    .btn-update:hover {
        background-color: #218838;
    }

    .btn-delete {
        background-color: #dc3545;
        margin-right: 5px;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .btn-add {
        background-color: #007bff;
    }

    .btn-add:hover {
        background-color: #0056b3;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    /* Style adjustment for textarea */
    textarea {
        resize: vertical; /* Allow vertical resizing */
    }

    /* Style for scrollable table */
    .table-container {
        overflow-y: auto; /* Enable vertical scrolling */
    }
</style>
</head>
<body>

<h2>PRODUCTS</h2>

<div class="table-container"> <!-- Wrap the table inside a div container -->
    <table>
        <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Expiry Date</th>
            <th>Category</th>
            <th>SRP</th>
            <th>VAT</th>
            <th>Loss Item</th>
            <th>Defect</th>
            <th>Return Refund</th>
            <th>Action</th>
        </tr>
        <?php
        // Connect to your database
        include 'config/db.php';

        // Display Table
        $sql = "SELECT * FROM PRODUCTS";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><form method='post' action='config/insertProd.php'>";
                echo "<td><input type='text' name='productName' value='" . $row['ProductName'] . "'></td>";
                echo "<td><textarea name='productDescription' rows='4'>" . $row['ProductDescription'] . "</textarea></td>";
                echo "<td><input type='date' name='expiryDate' value='" . $row['ExpiryDate'] . "'></td>";
                echo "<td><input type='text' name='category' value='" . $row['Category'] . "'></td>";
                echo "<td><input type='text' name='srp' value='" . $row['SRP'] . "'></td>";
                echo "<td><input type='text' name='vat' value='" . $row['VAT'] . "'></td>";
                echo "<td><input type='number' name='lossItem' value='" . $row['LossItem'] . "'></td>";
                echo "<td><input type='number' name='defect' value='" . $row['Defect'] . "'></td>";
                echo "<td><input type='number' name='Refund' value='" . $row['Refund'] . "'></td>";
                echo "<input type='hidden' name='productID' value='" . $row['ProductID'] . "'>";
                echo "<td><button type='submit' name='update' class='btn-update'>Update</button>";
                echo "<button class='btn-delete' type='submit' name='delete' value='" . $row['ProductID'] . "'>Delete</button></td>";
                echo "</form></tr>";
            }
        } else {
            echo "<tr><td colspan='10'>0 results</td></tr>";
        }
        echo "<tr><form method='post' action='config/insertProd.php'>";
        echo "<td><input type='text' name='newProductName' placeholder='Name'></td>";
        echo "<td><textarea name='newProductDescription' placeholder='Description' rows='4'></textarea></td>";
        echo "<td><input type='date' name='newExpiryDate' placeholder='Expiry Date'></td>";
        echo "<td><input type='text' name='newCategory' placeholder='Category'></td>";
        echo "<td><input type='text' name='newSRP' placeholder='SRP'></td>";
        echo "<td><input type='text' name='newVAT' placeholder='VAT'></td>";
        echo "<td><input type='number' name='newLossItem' placeholder='Loss'></td>";
        echo "<td><input type='number' name='newDefect' placeholder='Def'></td>";
        echo "<td><input type='number' name='newRefund' placeholder='Return'></td>";
        echo "<td><button type='submit' name='add' class='btn-add'>Add</button></td>";
        echo "</form></tr>";
        ?>
    </table>
</div>

</body>
</html>
