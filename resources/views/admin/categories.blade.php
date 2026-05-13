@extends('layouts.app')

@section('content')

<style>
    .container {
    margin: 40px auto;    
    font-family: Arial, sans-serif;
    max-width:100%;
    padding:30px;
    line-height:1.8;
    background: url('{{ asset("images/background 09.jpg") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    h1 {
        text-align: center;
        color:  white;
        margin-bottom: 25px;
    }

    form.add-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    input[type="text"] {
        flex: 1;
        padding: 12px;
        border: 2px solid #f48fb1;
        border-radius: 10px;
        outline: none;
        font-size: 16px;
    }

    input[type="text"]:focus {
        border-color: #e91e63;
        box-shadow: 0 0 5px rgba(233,30,99,0.3);
    }

    button {
        padding: 12px 18px;
        background: #e91e63;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
    }

    button:hover {
        background: #c2185b;
        transform: scale(1.05);
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

    hr {
        border: none;
        height: 1px;
        background: #f8bbd0;
        margin: 20px 0;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        margin: 10px 0;
        background: #fce4ec;
        border-radius: 10px;
        transition: 0.3s;
    }

    .category-item:hover {
        background: #f8bbd0;
    }

    .category-item span {
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }

    .delete-btn {
        background: #ff5252;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
    }

    .delete-btn:hover {
        background: #d32f2f;
    }
</style>

<div class="container">
    <h1>Manage Categories</h1>

    <form method="POST" action="/admin/categories" class="add-form">
        @csrf
        <input type="text" name="name" placeholder="Enter category name" required>
        <button type="submit">Add</button>
    </form>

    <hr>

    @foreach($categories as $category)
        <div class="category-item">
            <span>{{ $category->name }}</span>

            <form method="POST" action="/admin/categories/{{ $category->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">Delete</button>
            </form>
        </div>
    @endforeach
</div>
<a href="/admin/logout" class="logout-btn">🚪 Logout</a>
@endsection