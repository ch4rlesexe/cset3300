<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$checkouts = $pdo->query("SELECT checkout.*, student.name AS student_name, student.phone AS student_phone, book.title AS book_title
                          FROM checkout
                          JOIN student ON checkout.rocketid = student.rocketid
                          JOIN book ON checkout.bookid = book.bookid")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Management</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Checkout Management</h1>
        <a href="checkout.php" class="button-link">Record New Checkout</a>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Student</th>
                    <th>Phone Number</th>
                    <th>Promise Date</th>
                    <th>Return Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checkouts as $checkout): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($checkout['book_title']); ?></td>
                        <td><?php echo htmlspecialchars($checkout['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($checkout['student_phone']); ?></td>
                        <td><?php echo htmlspecialchars($checkout['promise_date']); ?></td>
                        <td><?php echo $checkout['return_date'] ? htmlspecialchars($checkout['return_date']) : '<span style="color: red;">Not Returned</span>'; ?></td>
                        <td>
                            <?php if (!$checkout['return_date']): ?>
                                <a href="return.php?id=<?php echo $checkout['checkoutid']; ?>" class="action-link">Mark as Returned</a>
                            <?php else: ?>
                                <span style="color: green;">Returned</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../home.php" class="button-link">Back to Home</a>
    </div>
</body>
</html>