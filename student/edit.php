<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $rocketid = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM student WHERE rocketid = :rocketid");
    $stmt->execute(['rocketid' => $rocketid]);
    $student = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        try {
            $update_stmt = $pdo->prepare("UPDATE student SET name = :name, phone = :phone, address = :address WHERE rocketid = :rocketid");
            $update_stmt->execute(['name' => $name, 'phone' => $phone, 'address' => $address, 'rocketid' => $rocketid]);
            $success_message = "Student updated successfully.";
        } catch (PDOException $e) {
            $error_message = "Error updating student: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="name">Student Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($student['address']); ?>" required>
            </div>
            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Update Student</button>
        </form>

        <a href="index.php" class="button-link">Back to Student Management</a>
    </div>
</body>
</html>
