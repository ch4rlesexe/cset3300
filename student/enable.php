<?php
require '../db.php';
require '../auth.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $rocketid = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE student SET active = 1 WHERE rocketid = :rocketid");
    $stmt->execute(['rocketid' => $rocketid]);

    header('Location: index.php');
    exit();
}
?>
