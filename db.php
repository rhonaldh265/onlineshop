<?php
$host = "dpg-d4g6ct8gjchc73dqueu0-a";
$dbname = "onlineshopping";
$user = "onlineshopping_qhm2_user";
$password = "XK1zP7fGh3V8f7VvIXkpEVaVlZLq8rYU";

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
