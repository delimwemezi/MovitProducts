<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background:  #e81a8b76;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn:hover {
            background: #45a049;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #333;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f9f9f9;
        }

        img {
            border-radius: 8px;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            font-size: 14px;
        }

        .edit {
            color: #007bff;
        }

        .delete {
            color: red;
        }

        .badge {
            background: #eee;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h1> Manage Products</h1>
    <a href="/admin/products/create" class="btn">Add Product</a>
</div>

@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<table>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>CartonPrice</th>
    <th>PiecePrice</th>
    <th>Action</th>
</tr>

@foreach($products as $product)
<tr>

    <!-- IMAGE -->
    <td>
        @if($product->image)
            <img src="{{ asset('images/' . $product->image) }}" width="70" height="70" style="object-fit:cover;">
        @else
            <span class="badge">No Image</span>
        @endif
    </td>

    <!-- NAME -->
    <td>{{ $product->name }}</td>

    <!-- PRICE -->
    <td><strong>Tsh {{ number_format($product->price) }}</strong></td>

    <!-- ACTION -->
    <td class="actions">
        <a href="/admin/products/edit/{{ $product->id }}" class="edit">✏ Edit</a>
        <a href="/admin/products/delete/{{ $product->id }}" 
           class="delete"
           onclick="return confirm('Are you sure you want to delete this product?')">
           🗑 Delete
        </a>
    </td>

</tr>
@endforeach

</table>
<a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</body>
</html>
