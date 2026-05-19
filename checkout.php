<?php
session_start();

if (empty($_SESSION['cart'])) {
    die("Cart is empty 🛒");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* 🌽 FARM BACKGROUND */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;
}

/* CARD */
.box{
    width:420px;
    background:rgba(255,255,255,0.96);
    padding:25px;
    border-radius:18px;
    box-shadow:0 0 25px rgba(0,0,0,0.35);
}

/* TITLE */
h2{
    text-align:center;
    color:#2e7d32;
    margin-bottom:20px;
}

/* LABEL */
label{
    font-weight:bold;
    font-size:13px;
    color:#444;
}

/* INPUTS */
input, textarea, select{
    width:100%;
    padding:12px;
    margin:8px 0 15px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
}

/* TEXTAREA */
textarea{
    resize:none;
    height:80px;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    background:#27ae60;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#1e8449;
    transform:scale(1.02);
}

/* ICON */
.icon{
    text-align:center;
    font-size:40px;
    margin-bottom:10px;
}

/* SMALL TEXT */
small{
    display:block;
    text-align:center;
    color:#666;
    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">🌽🛒</div>

    <h2>Checkout</h2>
    <small>Fresh Farm Products Order Form</small>

    <form method="POST" action="place_order.php">

        <label>Full Name</label>
        <input type="text" name="fullname" required>

        <label>Address</label>
        <textarea name="address" required></textarea>

        <label>Contact Number</label>
        <input type="text" name="contact" required>

        <label>Payment Method</label>
        <select name="payment_method" required>
            <option value="">-- Select Payment --</option>
            <option value="COD">Cash on Delivery (COD)</option>
            <option value="GCASH">GCash</option>
        </select>

        <button type="submit">Place Order 🌿</button>

    </form>

</div>

</body>
</html>