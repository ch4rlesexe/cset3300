<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $status = 1;

    try {
        $stmt = $pdo->prepare("INSERT INTO book (title, author, publisher, active) VALUES (:title, :author, :publisher, :active)");
        $stmt->execute(['title' => $title, 'author' => $author, 'publisher' => $publisher, 'active' => $status]);
        $success_message = "Book added successfully.";
    } catch (PDOException $e) {
        $error_message = "Error adding book: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Book</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="title">Book Title - </label>
                <input type="text" name="title" id="title" placeholder="Enter book title" required>
            </div>
            
            <div class="form-group">
                <label for="author">Author - </label>
                <input type="text" name="author" id="author" placeholder="Enter author name" required>
            </div>
            <div class="form-group">
                <label for="publisher">Publisher - </label>
                <input type="text" name="publisher" id="publisher" placeholder="Enter publisher name" required>
            </div>
            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Add Book</button>
        </form>
        <a href="index.php" class="button-link">Back to Book Management</a>
    </div>
</body>
</html>
