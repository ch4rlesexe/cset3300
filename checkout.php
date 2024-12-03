<?php
require '../db.php';
require '../auth.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rocketid = $_POST['rocketid'];
    $bookid = $_POST['bookid'];
    $promise_date = $_POST['promise_date'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM checkout WHERE bookid = :bookid AND return_date IS NULL");
        $stmt->execute(['bookid' => $bookid]);
        $existingCheckout = $stmt->fetch();

        if ($existingCheckout) {
            $error_message = "This book is already checked out and has not been returned.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO checkout (bookid, rocketid, promise_date) VALUES (:bookid, :rocketid, :promise_date)");
            $stmt->execute([
                'bookid' => $bookid,
                'rocketid' => $rocketid,
                'promise_date' => $promise_date
            ]);
            $success_message = "Checkout recorded successfully.";
        }
    } catch (PDOException $e) {
        $error_message = "Error recording checkout: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record New Checkout</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Record New Checkout</h1>

        <?php if (isset($success_message)): ?>
            <p class="success-text"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-text"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST" class="styled-form">
            <div class="form-group">
                <label for="rocketid">Select Student - </label> 
                <select name="rocketid" id="rocketid" required>
                    <option value="" disabled selected>Select a student</option>
                    <?php
                    $students = $pdo->query("SELECT * FROM student WHERE active = 1")->fetchAll();
                    foreach ($students as $student): ?>
                        <option value="<?php echo htmlspecialchars($student['rocketid']); ?>">
                            <?php echo htmlspecialchars($student['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bookid">Select which book - </label>
                <select name="bookid" id="bookid" required>
                    <option value="" disabled selected>Select a book</option>
                    <?php
                    $books = $pdo->query("SELECT * FROM book WHERE active = 1")->fetchAll();
                    foreach ($books as $book): ?>
                        <option value="<?php echo htmlspecialchars($book['bookid']); ?>">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="promise_date">Select promise date - </label>
                <input type="date" name="promise_date" id="promise_date" required>
            </div>

            <button type="submit" class="button-link" style="padding: 5px 5px; font-size: 1em;">Confirm Checkout</button>
        </form>
        <a href="index.php" class="button-link">Back to Home</a>
    </div>
</body>
</html>
