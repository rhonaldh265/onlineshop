<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $newProduct = [
        "name" => $_POST["name"],
        "material" => $_POST["material"],
        "size" => $_POST["size"],
        "price" => $_POST["price"],
        "image" => basename($_FILES["image"]["name"])
    ];

    $products = json_decode(file_get_contents("products.json"), true);
    $products[] = $newProduct;
    file_put_contents("products.json", json_encode($products, JSON_PRETTY_PRINT));

    echo "Product uploaded successfully! <a href='index.php'>View Catalog</a>";
} else {
    echo "Error uploading file.";
}
?>
