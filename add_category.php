<?php
// Include the template content
ob_start();
include('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;

// Include database connection
include('config/db.php');
$sql = "SELECT * FROM category";
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
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Category Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <form method="post" action="config/addcategory.php">
            <td></td>
            <td><input type="text" name="category_name" placeholder="Add Category Name" required></td>
            <td><input type="text" name="category_type" placeholder="Add Category Type" required></td>
            <td><button type="submit" class="btn btn-primary">Add</button></td>
        </form>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['category_id'] . "</td>";
            echo "<td><form method='post' action='config/updatecategory.php'>";
            echo "<input type='hidden' name='category_id' value='" . $row['category_id'] . "'>"; // Hidden input for variant ID
            echo "<input type='text' name='category_name' value='" . $row['category_name'] . "' required>";  
            echo "</td>";
            echo"<td><input type='text' name='category_type' value='" . $row['category_type'] . "' required></td>";
        echo"<td>";
            echo "<button type='submit' class='btn btn-info'>Update</button>";
            echo "</form>";
            // Delete button
            echo "<a href='config/deletecategory.php?delete=" . $row['category_id'] . "' class='btn btn-danger'>Delete</a></td>";
            echo"</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No Category found</td></tr>";
    }
    ?>
    </tbody>
  </table>
  
</body>
</html>
