<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel - Upload Product</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 5px; font-weight: bold; }
    input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
    button { background: #5a67d8; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; }
    .image-preview { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
    .image-preview img { width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: 2px solid #ddd; }
    .success { color: green; margin-top: 10px; padding: 10px; background: #f0fff0; border-radius: 4px; }
    .error { color: red; margin-top: 10px; padding: 10px; background: #fff0f0; border-radius: 4px; }
  </style>
</head>
<body>
  <h1>Upload Product with Multiple Images</h1>
  
  <form id="uploadForm" enctype="multipart/form-data">
    <div class="form-group">
      <label>Product Name:</label>
      <input type="text" name="name" placeholder="Product Name" required>
    </div>
    
    <div class="form-group">
      <label>Material:</label>
      <input type="text" name="material" placeholder="Material" required>
    </div>
    
    <div class="form-group">
      <label>Size:</label>
      <input type="text" name="size" placeholder="Size" required>
    </div>
    
    <div class="form-group">
      <label>Price (KES):</label>
      <input type="number" name="price" placeholder="Price" required>
    </div>
    
    <div class="form-group">
      <label>Product Images (Select 1-3 images):</label>
      <input type="file" name="images[]" multiple accept="image/*" required>
      <small>Hold Ctrl/Cmd to select multiple images</small>
    </div>
    
    <div class="form-group">
      <label>GitHub URL (optional):</label>
      <input type="url" name="github_url" placeholder="https://...">
    </div>
    
    <button type="submit">Upload Product</button>
    
    <div id="message"></div>
    <div id="imagePreviews" class="image-preview"></div>
  </form>

  <script>
    // Image preview
    document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
      const preview = document.getElementById('imagePreviews');
      preview.innerHTML = '';
      
      Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          preview.appendChild(img);
        }
        reader.readAsDataURL(file);
      });
    });

    // Form submission
    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const messageDiv = document.getElementById('message');
      
      try {
        const response = await fetch('upload.php', {
          method: 'POST',
          body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
          messageDiv.innerHTML = `<div class="success">✅ Product uploaded successfully! Images: ${result.images.join(', ')}</div>`;
          this.reset();
          document.getElementById('imagePreviews').innerHTML = '';
        } else {
          messageDiv.innerHTML = `<div class="error">❌ Error: ${result.error}</div>`;
        }
      } catch (error) {
        messageDiv.innerHTML = `<div class="error">❌ Network error: ${error.message}</div>`;
      }
    });
  </script>
</body>
</html>
