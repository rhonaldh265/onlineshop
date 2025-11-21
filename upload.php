<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$dataFile = __DIR__ . "/uploads/products.json";
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

$name = $_POST['name'];
$material = $_POST['material'];
$size = $_POST['size'];
$price = $_POST['price'];

$imageFiles = [];
foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $filename = uniqid() . "-" . basename($_FILES['images']['name'][$key]); 
    $target = __DIR__ . "/uploads/" . $filename;
    if (move_uploaded_file($tmp_name, $target)) {
        $imageFiles[] = $filename;
    }
}

// Add product entry with all uploaded images
$products[] = [
    "name" => $name,
    "material" => $material,
    "size" => $size,
    "price" => $price,
    "images" => $imageFiles
];

file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT));
header("Location: index.html");
?>
