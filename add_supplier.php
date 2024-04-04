<?php
// Include the template content
ob_start();
include('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;

// Include database connection
include('config/db.php');
$sql = "SELECT * FROM suppliers";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

  <table class="table">
    <thead>
        <tr>
            <th>Supplier ID</th>
            <th>Supplier Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <form method="post" action="config/addsupplier.php">
            <td></td>
            <td><input type="text" name="supplier_name" placeholder="Name" required></td>
            <td><input type="text" name="contact" placeholder="Contact" required></td>
            <td><input type="text" name="address" placeholder="Address" required></td>
            <td><button type="submit" class="btn btn-primary">Add</button></td>
        </form>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['supplier_id'] . "</td>";
            echo "<td><form method='post' action='config/updatesupplier.php'>";
            echo "<input type='hidden' name='supplier_id' value='" . $row['supplier_id'] . "'>"; // Hidden input for variant ID
            echo "<input type='text' name='supplier_name' value='" . $row['name'] . "' required>";  
            echo "</td>";
            echo"<td><input type='text' name='contact' value='" . $row['contact'] . "' required></td>";
            echo"<td><input type='text' name='address' value='" . $row['address'] . "' required></td>";
        
            echo"<td>";
            echo "<button type='submit' class='btn btn-info'>Update</button>";
            echo "</form>";
            // Delete button
            echo "<a href='config/deletesupplier.php?delete=" . $row['supplier_id'] . "' class='btn btn-danger'>Delete</a></td>";
            echo"</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No Supplier found</td></tr>";
    }
    ?>
    </tbody>
  </table>
  
</body>
</html>
