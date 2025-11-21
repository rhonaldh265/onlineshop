<?php
header('Content-Type: application/json');

$dataFile = __DIR__ . "/uploads/products.json";
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

echo json_encode($products);
?>
