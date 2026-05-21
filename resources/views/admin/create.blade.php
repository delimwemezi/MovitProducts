<!---
<h1>Add Product</h1>


    @csrf

    <input type="text" name="name" placeholder="Name"><br><br>

    <input type="number" name="price" placeholder="Price"><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>

     IMAGE INPUT -->   <!---
    <input type="file" name="image"><br><br>

    <button type="submit">Save</button>
</form>
-->

<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #ff4d6d, #6a5af9);
    }

    .form-container {
        width: 400px;
        margin: 50px auto;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    input, textarea, select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 14px;
        transition: 0.3s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.3);
    }

    textarea {
        resize: none;
        height: 80px;
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        background: #007bff;
        color: white;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #0056b3;
    }

       .logout-btn {
        background: #ff4d4d;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
        align-items: center;
        gap: 6px;
    }

    .logout-btn:hover {
        background: #cc0000;
        transform: scale(1.05);
    }

    .logout-btn:active {
        transform: scale(0.95);
    }
</style>

<div class="form-container">
    <h2>Add Product</h2>

   <form method="POST" action="/admin/products/store" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <input type="text" name="name" placeholder="Product Name" required>
        </div>

      <div class="form-group">
    <label for="CartonPrice">CartonPrice</label>
    <input type="number" name="CartonPrice" id="CartonPrice" placeholder="CartonPrice" step="0.01" min="0" required>
</div>

<div class="form-group">
    <label for="PiecePrice">PiecePrice</label>
    <input type="number" name="PiecePrice" id="PiecePrice" placeholder="PiecePrice" step="0.01" min="0" required>
</div>

        <div class="form-group">
            <textarea name="description" placeholder="Description"></textarea>
        </div>

        <div class="form-group">
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- IMAGE SOURCE TOGGLE -->
        <div class="form-group">
            <select id="imageSource" onchange="toggleImageSource()">
                <option value="device">Upload from Device</option>
                <option value="url">Use Online URL</option>
            </select>
        </div>

        <!-- UPLOAD FROM DEVICE -->
        <div class="form-group" id="deviceUpload">
            <input type="file" name="image_file" accept="image/*">
        </div>

        <!-- ONLINE URL -->
        <div class="form-group" id="urlUpload" style="display:none;">
            <input type="text" name="image_url" placeholder="https://example.com/image.jpg">
        </div>

        <button type="submit">Save Product</button>
    </form>
    <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</div>

<script>
function toggleImageSource() {
    const source = document.getElementById('imageSource').value;
    document.getElementById('deviceUpload').style.display = source === 'device' ? 'block' : 'none';
    document.getElementById('urlUpload').style.display = source === 'url' ? 'block' : 'none';
}
</script>
