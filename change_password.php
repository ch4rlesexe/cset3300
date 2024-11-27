<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $username = $_SESSION['admin_id'];

    $stmt = $pdo->prepare("SELECT * FROM user_authentication WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($current_password, $user['passwordhash'])) {
        $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

        $update_stmt = $pdo->prepare("UPDATE user_authentication SET passwordhash = :passwordhash WHERE username = :username");
        $update_stmt->execute(['passwordhash' => $hashed_new_password, 'username' => $username]);

        $success_message = "Password changed successfully.";
    } else {
        $error_message = "Current password is incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Change My Password</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required>
            </div>
            <br>
            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Change Password</button>
        </form>

<br>
        <a href="home.php" class="button-link">Back to Home</a>
    </div>
</body>
</html>
