<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dataFile = __DIR__ . "/uploads/products.json";

if (!file_exists($dataFile)) {
    http_response_code(404);
    echo json_encode(["error" => "Products file not found"]);
    exit;
}

$jsonData = file_get_contents($dataFile);
$products = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(["error" => "Invalid JSON format"]);
    exit;
}

// Convert single image to images array for frontend compatibility
foreach ($products as &$product) {
    if (isset($product['image']) && !isset($product['images'])) {
        $product['images'] = [$product['image']];
        // Remove the old image field if you want
        // unset($product['image']);
    }
    
    // Ensure github_url exists
    if (!isset($product['github_url'])) {
        $product['github_url'] = "#";
    }
}

echo json_encode($products);
?>
