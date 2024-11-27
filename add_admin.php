<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO user_authentication (username, passwordhash) VALUES (:username, :passwordhash)");
        $stmt->execute(['username' => $username, 'passwordhash' => $hashed_password]);
        $success_message = "New administrative assistant added successfully.";
    } catch (PDOException $e) {
        $error_message = "Error adding administrative assistant: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Administrative Assistant</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Administrative Assistant</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Add Assistant</button>
        </form>
<Br>
        <a href="home.php" class="button-link">Back to Home</a>
    </div>
</body>
</html>
