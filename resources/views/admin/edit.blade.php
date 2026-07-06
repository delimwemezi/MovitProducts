
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

        <div class="form-group">
    <label for="carton_price">Carton Price</label>
    <input type="number" name="carton_price" id="carton_price" placeholder="Carton Price" step="0.01" min="0" required value="{{ $product->carton_price }}">
</div>

<div class="form-group">
    <label for="piece_price">Piece Price</label>
    <input type="number" name="piece_price" id="piece_price" placeholder="Piece Price" step="0.01" min="0" required value="{{ $product->piece_price }}">
</div>

        <label>Description</label>
        <textarea name="description">{{ $product->description }}</textarea>

        <label>Category</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}"
                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{-- ↑ pre-selects the product's current category --}}
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

          <!-- ✅ Image Upload - displays current MySQL or Cloudinary image -->
    <label>Product Image</label>

    @if($product->primaryImage)
        {{-- NEW: Show image from MySQL --}}
        <div style="margin-bottom: 10px;">
            <p style="font-size: 13px; color: #555;">Current image (MySQL):</p>
            <img id="current-preview"
                 src="{{ route('product.image', $product->primaryImage->id) }}"
                 alt="Current product image"
                 style="width: 100%; max-height: 220px; object-fit: cover;
                        border-radius: 8px; border: 1px solid #ddd;">
        </div>
    @elseif($product->image)
        {{-- Fallback: Show existing Cloudinary image --}}
        <div style="margin-bottom: 10px;">
            <p style="font-size: 13px; color: #555;">Current image (Cloudinary):</p>
            <img id="current-preview"
                 src="{{ $product->image }}"
                 alt="Current product image"
                 style="width: 100%; max-height: 220px; object-fit: cover;
                        border-radius: 8px; border: 1px solid #ddd;">
        </div>
    @endif

    <input type="file" name="image" id="image-input" accept="image/*">

    <img id="new-preview" src="#" alt="New image preview"
         style="display:none; width: 100%; max-height: 220px;
                object-fit: cover; border-radius: 8px;
                border: 2px dashed #007bff; margin-bottom: 15px;">


        <button type="submit">Update Product</button>
    </form>

    <script>
    document.getElementById('image-input').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (evt) {
            const newPreview = document.getElementById('new-preview');
            newPreview.src = evt.target.result;
            newPreview.style.display = 'block';

            const current = document.getElementById('current-preview');
            if (current) current.style.opacity = '0.4';
        };
        reader.readAsDataURL(file);
    });
</script>
    <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</div>

