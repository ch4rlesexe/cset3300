<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $checkout_id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE checkout SET return_date = CURDATE() WHERE checkoutid = :checkoutid");
    $stmt->execute(['checkoutid' => $checkout_id]);
    header('Location: index.php');
    exit();
}
?>
