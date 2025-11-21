<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
</head>
<body>

<div style="position: absolute; top: 10px; right: 10px;">
  <form action="admin-login.php" method="post">
    <input type="password" name="pin" placeholder="Enter Admin PIN">
    <input type="submit" value="Admin Panel">
  </form>
</div>

  <h1>Add New Product</h1>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <label>Product Name:</label><input type="text" name="name"><br>
    <label>Material:</label><input type="text" name="material"><br>
    <label>Size:</label><input type="text" name="size"><br>
    <label>Price:</label><input type="text" name="price"><br>
    <label>Image:</label><input type="file" name="image"><br>
    <input type="submit" value="Upload Product">
  </form>
</body>
</html>
