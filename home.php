<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Library Management System</h1>
        <nav>
            <ul class="nav-menu">
                <li><a href="book/index.php">Manage Books</a></li>
                <li><a href="student/index.php">Manage Students</a></li>
                <li><a href="checkout/index.php">Manage Checkouts</a></li>
                <li><a href="add_admin.php">Add Assistant</a></li>
                <li><a href="change_password.php">Change My Password</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
