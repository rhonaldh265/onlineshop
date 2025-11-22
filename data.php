<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Create database if it doesn't exist
    if (!file_exists('products.db')) {
        $db = new SQLite3('products.db');
        $db->exec('CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            material TEXT NOT NULL,
            size TEXT NOT NULL,
            price REAL NOT NULL,
            images TEXT NOT NULL,
            github_url TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )');
    } else {
        $db = new SQLite3('products.db');
    }
    
    $result = $db->query('SELECT * FROM products ORDER BY id DESC');
    $products = [];
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Convert JSON images string to array
        $row['images'] = json_decode($row['images'], true);
        
        // Ensure github_url exists
        if (empty($row['github_url'])) {
            $row['github_url'] = "#";
        }
        
        $products[] = $row;
    }
    
    // If no products, return empty array
    echo json_encode($products ?: []);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
