<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $material = $_POST['material'] ?? '';
    $size = $_POST['size'] ?? '';
    $price = $_POST['price'] ?? '';
    $github_url = $_POST['github_url'] ?? '';
    
    // Validate required fields
    if (empty($name) || empty($material) || empty($size) || empty($price)) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }
    
    try {
        // Connect to SQLite database
        $db = new SQLite3('products.db');
        
        // Handle file uploads
        $uploadedImages = [];
        $uploadDir = __DIR__ . '/uploads/';
        
        // Create uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Process multiple images
        if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    // Generate unique filename
                    $fileExtension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                    $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $_FILES['images']['name'][$key]);
                    $uploadFile = $uploadDir . $fileName;
                    
                    // Validate image file
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (in_array(strtolower($fileExtension), $allowedTypes)) {
                        if (move_uploaded_file($tmp_name, $uploadFile)) {
                            $uploadedImages[] = $fileName;
                        }
                    }
                }
            }
        }
        
        if (empty($uploadedImages)) {
            echo json_encode(["error" => "No valid images uploaded"]);
            exit;
        }
        
        // Insert product into database
        $stmt = $db->prepare('INSERT INTO products (name, material, size, price, images, github_url) VALUES (?, ?, ?, ?, ?, ?)');
        $imagesJson = json_encode($uploadedImages);
        
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $material);
        $stmt->bindValue(3, $size);
        $stmt->bindValue(4, $price);
        $stmt->bindValue(5, $imagesJson);
        $stmt->bindValue(6, $github_url);
        
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Product uploaded successfully",
                "images" => $uploadedImages,
                "product_id" => $db->lastInsertRowID()
            ]);
        } else {
            echo json_encode(["error" => "Failed to save product"]);
        }
        
    } catch (Exception $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
    
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
