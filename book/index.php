<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$books = $pdo->query("SELECT * FROM book")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Book Management</h1>
        <a href="add.php" class="button-link">Add New Book</a>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['publisher']); ?></td>
                        <td>
                            <span class="<?php echo $book['active'] ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo $book['active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $book['bookid']; ?>" class="action-link">Edit</a> |
                            <?php if ($book['active']): ?>
                                <a href="delete.php?id=<?php echo $book['bookid']; ?>" class="action-link">Remove</a>
                            <?php else: ?>
                                <a href="enable.php?id=<?php echo $book['bookid']; ?>" class="action-link">Enable</a>
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
