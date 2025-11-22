<?php
// Run this once to initialize the database
try {
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
    
    // Insert sample data (optional)
    $sampleProducts = [
        [
            'name' => 'Sample Blouse',
            'material' => 'Silk',
            'size' => 'M',
            'price' => 2500,
            'images' => json_encode(['sample1.jpg', 'sample2.jpg', 'sample3.jpg']),
            'github_url' => 'https://example.com/sample.jpg'
        ]
    ];
    
    $stmt = $db->prepare('INSERT INTO products (name, material, size, price, images, github_url) VALUES (?, ?, ?, ?, ?, ?)');
    
    foreach ($sampleProducts as $product) {
        $stmt->bindValue(1, $product['name']);
        $stmt->bindValue(2, $product['material']);
        $stmt->bindValue(3, $product['size']);
        $stmt->bindValue(4, $product['price']);
        $stmt->bindValue(5, $product['images']);
        $stmt->bindValue(6, $product['github_url']);
        $stmt->execute();
    }
    
    echo "Database created successfully with sample data!";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
