<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #ff4d6d, #6a5af9);
    }

    .form-container {
        width: 450px;
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

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 14px;
    }

    input, textarea, select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 14px;
        transition: 0.3s;
        box-sizing: border-box;
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

    .info-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 13px;
        color: #856404;
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
        display: inline-block;
        margin-top: 15px;
    }

    .logout-btn:hover {
        background: #cc0000;
        transform: scale(1.05);
    }
</style>

<div class="form-container">
    <h2>Add Product</h2>

    <div class="info-box">
        📸 <strong>Image URL:</strong> Paste your Cloudinary image URL here
    </div>

   <form method="POST" action="/admin/products/store">
        @csrf

        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" placeholder="e.g. Baby Gel" required>
        </div>

        <div class="form-group">
            <label>Carton Price *</label>
            <input type="number" name="carton_price" placeholder="0.00" step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label>Piece Price *</label>
            <input type="number" name="piece_price" placeholder="0.00" step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" placeholder="Product description..."></textarea>
        </div>

        <div class="form-group">
            <label>Category *</label>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Image URL</label>
            <input type="url" name="image" placeholder="https://res.cloudinary.com/ekgqdteo/image/upload/...">
        </div>

        <button type="submit">Save Product</button>
    </form>
    <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</div>

