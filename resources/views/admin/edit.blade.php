
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

    <form method="POST" action="/admin/products/update/{{ $product->id }}">
        @csrf
        @method('PUT')

        <label>Product Name</label>
        <input type="text" name="name" value="{{ $product->name }}" required>

        <label>Price</label>
        <input type="number" name="price" value="{{ $product->price }}" required>

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

        <button type="submit">Update Product</button>
    </form>
    <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</div>

