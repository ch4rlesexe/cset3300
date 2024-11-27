<?php
$config = parse_ini_file("myproperties.ini", true);
$host = trim($config['DB']['DBHOST'], "\"");
$dbname = trim($config['DB']['DBNAME'], "\"");
$username = trim($config['DB']['DBUSER'], "\"");
$password = trim($config['DB']['DBPASS'], "\"");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
