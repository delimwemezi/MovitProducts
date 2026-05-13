<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e81a8b76; padding: 40px; }
        h1 { color: black; text-align: center; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        th, td { padding: 12px 20px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #E81A8A; color: white; }
        .btn { padding: 8px 15px; border: none; border-radius: 8px; cursor: pointer; }
        .btn-delete { background: red; color: white; }
        .btn-add { background: #E81A8A; color: white; padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer; }
        form.inline { display: inline; }
        .form-box { background: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; }
        input { padding: 10px; margin: 5px 0; width: 100%; border-radius: 8px; border: 1px solid #ddd; }


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

<h1>Manage Admins</h1>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <p style="text-align:center; color:green;">{{ session('success') }}</p>
@endif

{{-- CREATE ADMIN FORM --}}
<div class="form-box">
    <h2>Add New Admin</h2>
    <form method="POST" action="/admin/admins">
        @csrf
        <input type="text"     name="name"     placeholder="Name"     required>
        <input type="email"    name="email"    placeholder="Email"    required>
        <input type="password" name="password" placeholder="Password" required>
        <br><br>
        <button type="submit" class="btn-add">Create Admin</button>
    </form>
</div>

{{-- ADMINS TABLE --}}
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admins as $admin)
        <tr>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>
                <form method="POST" action="/admin/admins/{{ $admin->id }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete"
                        onclick="return confirm('Remove this admin?')">
                        Remove
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
<a href="/admin/logout" class="logout-btn">🚪 Logout</a>

<a href="/admin/dashboard">← Back to Dashboard</a>

</body>
</html>