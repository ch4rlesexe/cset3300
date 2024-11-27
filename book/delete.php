<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE book SET active = 0 WHERE bookid = :bookid");
    $stmt->execute(['bookid' => $book_id]);

    header('Location: index.php');
    exit();
}
?>
