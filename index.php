<?php
// Load products from JSON
$products = json_decode(file_get_contents("products.json"), true);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Classic Shop</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Admin button -->
  <div style="position: absolute; top: 10px; right: 10px;">
    <a href="admin-login.html" style="padding: 8px; background:#333; color:#fff; text-decoration:none; border-radius:4px;">
      Admin Panel
    </a>
  </div>

  <h1>Product Catalog</h1>
  <div class="product-grid">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $p): ?>
        <div class="product-card">
          <div class="product-image">
            <img src="uploads/<?php echo $p['image']; ?>" alt="<?php echo $p['name']; ?>">
          </div>
          <div class="product-info">
            <h3><?php echo $p['name']; ?></h3>
            <p>Material: <?php echo $p['material']; ?></p>
            <p>Size: <?php echo $p['size']; ?></p>
            <span class="price">KES <?php echo $p['price']; ?></span>
            <button class="add-btn">Add to Basket</button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products yet. Please add some via the Admin Panel.</p>
    <?php endif; ?>
  </div>
</body>
</html>
