<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database configuration
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

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
    
    // Handle file uploads
    $uploadedImages = [];
    $uploadDir = __DIR__ . '/uploads/';
    
    // Create uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Process multiple images
    if (isset($_FILES['images'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
                $uploadFile = $uploadDir . $fileName;
                
                // Validate image file
                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($imageFileType, $allowedTypes)) {
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
    
    try {
        // Insert product into database
        $stmt = $pdo->prepare("INSERT INTO products (name, material, size, price, images, github_url) VALUES (?, ?, ?, ?, ?, ?)");
        $imagesJson = json_encode($uploadedImages);
        $stmt->execute([$name, $material, $size, $price, $imagesJson, $github_url]);
        
        echo json_encode([
            "success" => true,
            "message" => "Product uploaded successfully",
            "images" => $uploadedImages,
            "product_id" => $pdo->lastInsertId()
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
    
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
