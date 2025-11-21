<?php
$dataFile = __DIR__ . "/uploads/products.json";
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>
