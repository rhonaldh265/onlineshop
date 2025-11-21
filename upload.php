
<?php
require 'db.php'; // connects to your database

// Save image to uploads folder
$targetDir = "uploads/";
$imageName = basename($_FILES["image"]["name"]);
$targetFile = $targetDir . $imageName;
move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

// Insert product into database
$stmt = $pdo->prepare("INSERT INTO products (name, material, size, price, image) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([
  $_POST["name"],
  $_POST["material"],
  $_POST["size"],
  $_POST["price"],
  $imageName
]);

echo "Product uploaded successfully! <a href='index.php'>View Catalog</a>";
?>

