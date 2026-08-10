<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #fff0f7 0%, #f5f3ff 100%);
            padding: 40px 20px;
            color: #1f2937;
        }
        .page-shell {
            max-width: 1100px;
            margin: 0 auto;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        h1 {
            margin: 0;
            color: #2f1748;
            font-size: clamp(2rem, 3vw, 2.6rem);
        }
        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .top-link,
        .logout-btn,
        .btn,
        .btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .top-link,
        .logout-btn {
            padding: 10px 16px;
            font-size: 0.92rem;
        }
        .top-link {
            background: #ede9fe;
            color: #4c1d95;
        }
        .logout-btn {
            background: #ef4444;
            color: white;
        }
        .top-link:hover,
        .logout-btn:hover,
        .btn:hover,
        .btn-add:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.15);
        }
        .alert-success {
            margin: 0 0 18px;
            padding: 12px 16px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 600;
        }
        .form-box {
            background: rgba(255,255,255,0.92);
            border: 1px solid #f3d8ea;
            border-radius: 18px;
            padding: 26px;
            margin-bottom: 28px;
            box-shadow: 0 16px 32px rgba(124, 58, 237, 0.08);
        }
        .form-box h2 {
            margin: 0 0 18px;
            color: #2f1748;
            font-size: 1.3rem;
        }
        .admin-form {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            align-items: end;
        }
        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #e5d5f7;
            background: #faf5ff;
            font-size: 0.96rem;
        }
        .btn-add {
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            color: white;
            padding: 12px 18px;
            min-height: 48px;
        }
        .table-wrap {
            background: rgba(255,255,255,0.95);
            border: 1px solid #f3d8ea;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 16px 32px rgba(124, 58, 237, 0.08);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid #f1d8ea;
        }
        th {
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            color: white;
            font-size: 0.8rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        tbody tr:hover {
            background: #faf5ff;
        }
        .btn {
            padding: 9px 14px;
            font-size: 0.82rem;
        }
        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        form.inline { display: inline; }
        @media (max-width: 760px) {
            .admin-form {
                grid-template-columns: 1fr;
            }
            .page-header {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="page-shell">
    <div class="page-header">
        <h1>Manage Admins</h1>
        <div class="header-actions">
            <a href="/admin/dashboard" class="top-link">← Back to Dashboard</a>
            <a href="/admin/logout" class="logout-btn">🚪 Logout</a>
        </div>
    </div>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    <div class="form-box">
        <h2>Add New Admin</h2>
        <form method="POST" action="/admin/admins" class="admin-form">
            @csrf
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-add">Create Admin</button>
        </form>
    </div>

    <div class="table-wrap">
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
    </div>
</div>
</body>
</html>