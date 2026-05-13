<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="/css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74,144,226,0.3);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #357abd;
        }

        .container p {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>🛒 Checkout</h2>

    <form action="/place-order" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Your Full Name" required>

        <input type="text" name="phone" placeholder="Phone Number (e.g. 07XXXXXXXX)" required>

        <textarea name="address" placeholder="Delivery Address"></textarea>

        <button class="btn">Place Order</button>
    </form>

    <p>Secure checkout • Fast delivery • Trusted store</p>
</div>

</body>
@include('partials.alerts')
</html>