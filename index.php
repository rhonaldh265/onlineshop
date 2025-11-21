<?php
$products = json_decode(file_get_contents("products.json"), true);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Classic Shop</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div style="position: absolute; top: 10px; right: 10px;">
  <form action="admin-login.php" method="post">
    <input type="password" name="pin" placeholder="Enter Admin PIN">
    <input type="submit" value="Admin Panel">
  </form>
</div>

  <div class="product-grid">
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
  </div>
</body>
</html>
