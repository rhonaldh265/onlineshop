<?php
$dataFile = __DIR__ . "/uploads/products.json";

// Ensure file exists
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, "[]");
}

// Load existing products
$products = json_decode(file_get_contents($dataFile), true);

// Add new product
$products[] = [
    "name" => $_POST["name"],
    "material" => $_POST["material"],
    "size" => $_POST["size"],
    "price" => $_POST["price"],
    "image" => basename($_FILES["image"]["name"])
];

// Save back to JSON
file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT));

// Move uploaded image
$targetDir = __DIR__ . "/uploads/";
move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . basename($_FILES["image"]["name"]));

echo "Product uploaded successfully! <a href='index.php'>View Catalog</a>";
?>
