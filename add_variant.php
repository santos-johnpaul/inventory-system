<?php
// Include the template content
ob_start();
include('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;

// Include database connection
include('config/db.php');

// Retrieve data from the database
$sql = "SELECT * FROM variant";
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
            <th>Variant ID</th>
            <th>Variant Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <form method="post" action="config/addvariant.php">
            <td></td>
            <td><input type="text" name="variant_name" placeholder="Add Variant" required></td>
            <td><button type="submit" class="btn btn-primary">Add</button></td>
        </form>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['variant_id'] . "</td>";
            // Form for updating variant name
            echo "<td><form method='post' action='config/updatevariant.php'>";
            echo "<input type='hidden' name='variant_id' value='" . $row['variant_id'] . "'>"; // Hidden input for variant ID
            echo "<input type='text' name='variant_name' value='" . $row['variant'] . "' required>"; // Input for variant name
            echo "<td>";
            // Update button
            echo "<button type='submit' class='btn btn-info'>Update</button>";
            echo "</form>";
            // Delete button
            echo "<a href='config/deletevariant.php?delete=" . $row['variant_id'] . "' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No variants found</td></tr>";
    }
    ?>
    </tbody>
  </table>
  
</body>
</html>
