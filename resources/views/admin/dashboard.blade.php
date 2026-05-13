<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #e81a8b76;
        margin: 0;
        padding: 0;
    }

    .dashboard {
        text-align: center;
        padding: 50px;
    }

    h1 {
        color: white;
        margin-bottom: 40px;
        font-size: 40px;
    }

    .card-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .card {
    /*background: url('../images/BackGround 12.webp'); /* path to your image */
    /*background-size: cover;       /* make image cover whole card */
    /*background-position: center;  /* center the image */
    /*background-repeat: no-repeat;*/    

        padding: 30px;
        border-radius: 15px;
        width: 220px;
        text-decoration: none;
        color: #128aedfa;
        height: 40px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* Hover Effect */
    .card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    /* Click Effect */
    .card:active {
        transform: scale(0.95);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Shine animation */
    .card::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: -100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.5), transparent);
        transition: 0.5s;
    }

    .card:hover::before {
        left: 100%;
    }

    .card h2 {
        margin: 10px 0;
    }

    .icon {
        font-size: 40px;
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

</style>
</head>

<body>

<div class="dashboard">
    <h1>Admin Dashboard</h1>

    <div class="card-container">

        <a href="/" class="card">
            <div class="icon"></div>
            <h2>View Shop</h2>
        </a>
        
        <a href="/admin/categories" class="card">
          <h2>ManageCategories</h2>
       </a>

       <a href="/admin/admins" class="card">
           <h2>ManageAdmins</h2>
        </a> 

        <a href="/admin/products" class="card">
            <div class="icon"></div>
            <h2>Manage Products</h2>
        </a>
         <!---
        <a href="/admin/orders" class="card">
            <div class="icon">🧾</div>
            <h2>View Orders</h2>
        </a>
         -->

    </div>
</div>

<a href="/admin/logout" class="logout-btn">🚪 Logout</a>
</body>
</html>