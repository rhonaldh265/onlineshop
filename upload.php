<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dataFile = __DIR__ . "/uploads/products.json";

// Ensure JSON file exists
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, "[]");
}

// Load existing products
$products = json_decode(file_get_contents($dataFile), true);

// Save image
$targetDir = __DIR__ . "/uploads/";
$imageName = basename($_FILES["image"]["name"]);
move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $imageName);

// Add new product
$products[] = [
    "name" => $_POST["name"],
    "material" => $_POST["material"],
    "size" => $_POST["size"],
    "price" => $_POST["price"],
    "image" => $imageName
];

// Save back to JSON
file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT));

echo "Product uploaded successfully! <a href='index.php'>View Catalog</a>";
?>

