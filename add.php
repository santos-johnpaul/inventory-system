<?php
// Include the template content
ob_start();
include('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;

// Assuming $conn is your database connection, you need to establish it before using this code
// Adjust the database connection accordingly
include('config/db.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 15px;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Set a maximum width for larger screens */
            width: 100%; /* Occupy full width for smaller screens */
            margin: auto; /* Center the form on larger screens */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        input,
        select,
        button {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        select {
            appearance: none;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 16px;
            cursor: pointer;
            border-radius: 6px;
        }

        button:hover {
            background-color: #45a049;
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Media queries for responsiveness */
        @media (max-width: 600px) {
            form {
                padding: 10px; /* Adjust padding for smaller screens */
            }
            th, td {
                padding: 10px; /* Adjust padding for smaller screens */
            }
        }

        /* Additional styles */
        .table-container {
            overflow-x: auto;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .update-btn, .delete-btn {
            background-color: #2196F3;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 6px;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .update-btn:hover, .delete-btn:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>
    
        <h4><b>Add User</b></h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Picture</th>
                        <th>Action</th>
                    </tr>
                </thead>
           
        
                <?php

$result = $conn->query("SELECT * FROM users");
if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       echo"<form action='config/updateuser.php' method='POST'>";
        echo "<tr>";
        // Displaying input field for "User Name"
        echo "<td><input type='text' name='update_username' value='{$row['username']}'></td>";
        // Displaying input field for "Password"
        echo "<td><input type='password' name='update_password' value='{$row['password']}'></td>";
        // Displaying input field for "Role"
        echo "<td><input type='text' name='update_role' value='{$row['role']}'></td>";
        // Displaying input field for "Picture Path"
        echo "<td><input type='file' name='update_pic' value='{$row['pic']}'></td>";
        
        // Action buttons
        echo "<td class='action-buttons'>";
        echo"<input type= 'hidden' name='updateusers' value='{$row['user_id']}'>";
        echo "<button class='update-btn' type='submit'name='updateuser'>Update</button>";
        echo"</form>";
        echo"<form action='config/deleteuser.php' method='POST'>";
        echo"<input type= 'hidden' name='deleteuser' value='{$row['user_id']}'>";
        echo "<button class='delete-btn'>Delete</button>";
        echo"</form>";
        
        echo "</td>";
        
        echo "</tr>";
    }
}
?>
                <form action="config/addUser.php" method="POST" enctype="multipart/form-data">
                    <tr>
                        <td><input type="text" id="username" name="username" required></td>
                        <td><input type="password" id="password" name="password" required></td>
                        <td>
                            <select id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </td>
                        <td><input type="file" name="pic" id="pic" required></td>
                        <td><button type="submit" >ADD</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</body>
</html>
