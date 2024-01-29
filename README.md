# inventory-system 

<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>Your role: <?php echo $role; ?></p>

    <a href="config/logout.php">Logout</a>

</body>
</html>