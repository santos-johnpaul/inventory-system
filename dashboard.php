<?php
// Include the template content
ob_start();
include('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icon Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            display: flex;
            justify-content: start;
            align-items:flex-start;
            height: 100vh;
        }

        .icon-container {
            text-align: center;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .label {
            font-size: 18px;
            color: #333;
        }

        .total {
            font-size: 16px;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="dashboard">
        <div class="icon-container">
            <div class="icon">&#128721;</div>
            <a href="addProd.php">
            <div class="label">Product</div>
            </a>
            <?php
            include 'config/db.php';

            // Query to count total products
            $sql = "SELECT COUNT(*) AS ProductName FROM products";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $totalProducts = $row['ProductName'];
                echo "<p class='total'>Total Products: " . $totalProducts . "</p>";
            } else {
                echo "<p class='total'>Error: " . $conn->error . "</p>";
            }
            ?>
        </div>

        <div class="icon-container">
            <div class="icon">&#128465;</div>
            <a href="addProd.php">
            <div class="label">Loss Item</div>
            </a>
            <?php
            $sql = "SELECT SUM(LossItem) AS totalLostItems FROM productdetails";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $totalLostItems = $row['totalLostItems'];
                echo "<p class='total'>Total Lost Items: " . $totalLostItems . "</p>";
            } else {
                echo "<p class='total'>Error: " . $conn->error . "</p>";
            }
            ?>
        </div>

        <div class="icon-container">
            <div class="icon">&#9762;</div>
            <a href="addProd.php">
            <div class="label">Defect</div>
            </a>
            <?php
            $sql = "SELECT SUM(Defect) AS totalLostDefect FROM productdetails";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $totalLostDefect = $row['totalLostDefect'];
                echo "<p class='total'>Total Defect: " . $totalLostDefect . "</p>";
            } else {
                echo "<p class='total'>Error: " . $conn->error . "</p>";
            }
            ?>
        </div>

        <div class="icon-container">
            <div class="icon">&#128184;</div>
            <a href="addProd.php">
            <div class="label">Refund</div>
            </a>
            <?php
            $sql = "SELECT SUM(Refund) AS totalRefund FROM productdetails";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $totalRefund = $row['totalRefund'];
                echo "<p class='total'>Total Refund: " . $totalRefund . "</p>";
            } else {
                echo "<p class='total'>Error: " . $conn->error . "</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>
