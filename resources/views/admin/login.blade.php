<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="icon" type="image/favicon.ico" href="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

<body class="login-body">

<div class="login-wrapper">

    <div class="login-box">
        <h2> Admin Login</h2>
        <p>Welcome back! Please login to continue</p>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</div>

</body>
</html>