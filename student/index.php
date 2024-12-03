<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$students = $pdo->query("SELECT * FROM student")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Student Management</h1>
        <a href="add.php" class="button-link">Add New Student</a>
        
        <table class="styled-table">
            <thead>
                <tr>
                    <br>
                    <th>Rocket ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tbody>
                
                <?php foreach ($students as $student): ?>
                    <tr>
                        
                        <td><?php echo htmlspecialchars($student['rocketid']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['phone']); ?></td>
                        <td><?php echo htmlspecialchars($student['address']); ?></td>
                        <td>
                            <span class="<?php echo $student['active'] ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo $student['active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $student['rocketid']; ?>" class="action-link">Edit</a> |
                            <?php if ($student['active']): ?>
                                <a href="delete.php?id=<?php echo $student['rocketid']; ?>" class="action-link">Disable</a>
                            <?php else: ?>
                                <a href="enable.php?id=<?php echo $student['rocketid']; ?>" class="action-link">Enable</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="../home.php" class="button-link">Back to Home</a>
    </div>
</body>
</html>
