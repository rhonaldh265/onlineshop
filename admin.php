<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
</head>
<body>
  <h1>Upload Product</h1>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <input type="text" name="material" placeholder="Material" required><br>
    <input type="text" name="size" placeholder="Size" required><br>
    <input type="number" name="price" placeholder="Price" required><br>
    <input type="file" name="image" required><br>
    <input type="submit" value="Upload">
  </form>
</body>
</html>
