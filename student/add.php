<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rocketid = $_POST['rocketid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = 1;

    try {
        $stmt = $pdo->prepare("INSERT INTO student (rocketid, name, phone, address, active) VALUES (:rocketid, :name, :phone, :address, :active)");
        $stmt->execute(['rocketid' => $rocketid, 'name' => $name, 'phone' => $phone, 'address' => $address, 'active' => $status]);
        $success_message = "Student added successfully.";
    } catch (PDOException $e) {
        $error_message = "Error adding student: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Student</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="rocketid">Rocket ID:</label>
                <input type="text" name="rocketid" id="rocketid" placeholder="Enter Rocket ID" required>
            </div>
            
            <div class="form-group">
                <label for="name">Student Name:</label>
                <input type="text" name="name" id="name" placeholder="Enter student name" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" placeholder="Enter phone number" required>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" placeholder="Enter address" required>
            </div>
            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Add Student</button>
        </form>

        <a href="index.php" class="button-link">Back to Student Management</a>
    </div>
</body>
</html>
