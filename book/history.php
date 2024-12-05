<?php
require '../db.php';
require '../auth.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['bookid'])) {
    $bookid = $_GET['bookid'];
    $stmt = $pdo->prepare("
        SELECT checkout.*, student.name AS student_name, student.phone AS student_phone
        FROM checkout
        JOIN student ON checkout.rocketid = student.rocketid
        WHERE checkout.bookid = :bookid
    ");
    $stmt->execute(['bookid' => $bookid]);
    $history = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout History</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Checkout History</h1>
        <?php if ($history): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Phone Number</th>
                        <th>Promise Date</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($entry['student_phone']); ?></td>
                            <td><?php echo htmlspecialchars($entry['promise_date']); ?></td>
                            <td><?php echo $entry['return_date'] ? htmlspecialchars($entry['return_date']) : 'Not Returned'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No history available for this book.</p>
        <?php endif; ?>
        <a href="index.php" class="button-link">Back to Book Management</a>
    </div>
</body>
</html>
