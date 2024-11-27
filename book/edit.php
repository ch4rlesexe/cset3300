<?php
require '../db.php';
require '../auth.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM book WHERE bookid = :bookid");
    $stmt->execute(['bookid' => $book_id]);
    $book = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $publisher = $_POST['publisher'];

        try {
            $update_stmt = $pdo->prepare("UPDATE book SET title = :title, author = :author, publisher = :publisher WHERE bookid = :bookid");
            $update_stmt->execute(['title' => $title, 'author' => $author, 'publisher' => $publisher, 'bookid' => $book_id]);
            $success_message = "Book updated successfully.";
        } catch (PDOException $e) {
            $error_message = "Error updating book: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Book</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="title">Book Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>
            <div class="form-group">
                <label for="publisher">Publisher:</label>
                <input type="text" name="publisher" id="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" required>
            </div>
            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Update Book</button>
        </form>
        <a href="index.php" class="button-link">Back to Book Management</a>
    </div>
</body>
</html>
