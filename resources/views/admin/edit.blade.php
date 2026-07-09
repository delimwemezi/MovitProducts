
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff4d6d, #6a5af9);
            padding: 30px;
        }
        .form-container {
            max-width: 500px;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin: auto;
        }
        h1 { text-align: center; margin-bottom: 20px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.3);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }

        .image-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .image-section h4 {
            margin-top: 0;
            color: #333;
        }

        .current-image {
            margin-bottom: 15px;
        }

        .current-image img {
            max-width: 100%;
            max-height: 220px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .divider {
            text-align: center;
            margin: 15px 0;
            color: #999;
            font-size: 14px;
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
        margin-top: 10px;
    }

    .logout-btn:hover {
        background: #cc0000;
        transform: scale(1.05);
    }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit Product</h1>

    <form method="POST" action="/admin/products/update/{{ $product->id }}"
    enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Product Name</label>
        <input type="text" name="name" value="{{ $product->name }}" required>

        <label for="carton_price">Carton Price</label>
        <input type="number" name="carton_price" id="carton_price" placeholder="Carton Price" step="0.01" min="0" required value="{{ $product->carton_price }}">

        <label for="piece_price">Piece Price</label>
        <input type="number" name="piece_price" id="piece_price" placeholder="Piece Price" step="0.01" min="0" required value="{{ $product->piece_price }}">

        <label>Description</label>
        <textarea name="description">{{ $product->description }}</textarea>

        <label>Category</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}"
                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- ✅ Image Upload Section -->
        <div class="image-section">
            <h4>📸 Product Image</h4>
            
            @if($product->image)
                <div class="current-image">
                    <p style="font-size: 13px; color: #555; margin-bottom: 8px;">Current image:</p>
                    <img src="{{ $product->image }}" alt="Current product image">
                </div>
            @endif

            <div class="form-group">
                <label for="image_file"><strong>Upload New Image from Device</strong></label>
                <input type="file" name="image_file" id="image_file" accept="image/*">
            </div>

            <div class="divider">OR</div>

            <div class="form-group">
                <label for="image_url"><strong>Use Image URL</strong></label>
                <input type="url" name="image_url" id="image_url" placeholder="https://example.com/image.jpg">
            </div>
        </div>

        <button type="submit">Update Product</button>
    </form>

    <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</div>


