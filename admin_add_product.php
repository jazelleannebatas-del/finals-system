<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

if (isset($_POST['save'])) {

    $name  = $_POST['product_name'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $image);

    mysqli_query($conn,
        "INSERT INTO products(product_name, price, image)
         VALUES('$name', '$price', '$image')"
    );

    header("location:admin_add_product.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Upload Product</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* 🌾 BACKGROUND */
body{
    height:100vh;

    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;

    display:flex;
    justify-content:center;
    align-items:center;
}

/* MAIN CARD */
.container{
    width:420px;
    background:rgba(255,255,255,0.95);
    padding:35px;
    border-radius:18px;
    box-shadow:0 0 25px rgba(0,0,0,0.35);
}

/* ICON */
.icon{
    text-align:center;
    font-size:60px;
    margin-bottom:10px;
}

/* TITLE */
h2{
    text-align:center;
    color:#2e7d32;
    margin-bottom:25px;
    font-size:30px;
}

/* INPUTS */
input{
    width:100%;
    padding:14px;
    margin-bottom:18px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:15px;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#43a047;
    box-shadow:0 0 8px rgba(67,160,71,0.4);
}

/* FILE INPUT */
input[type="file"]{
    background:#f5f5f5;
    cursor:pointer;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    background:#43a047;
    color:white;
    border:none;
    border-radius:10px;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#2e7d32;
    transform:scale(1.02);
}

/* LINKS */
.links{
    margin-top:20px;
    text-align:center;
}

.links a{
    display:inline-block;
    margin:8px;
    padding:10px 18px;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

/* VIEW BUTTON */
.view-btn{
    background:#3498db;
    color:white;
}

.view-btn:hover{
    background:#217dbb;
}

/* BACK BUTTON */
.back-btn{
    background:#e67e22;
    color:white;
}

.back-btn:hover{
    background:#ca6b17;
}

/* FOOTER */
.footer{
    text-align:center;
    margin-top:20px;
    color:#555;
    font-size:14px;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

    <div class="icon">🥬🍎🥕</div>

    <h2>Upload Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text"
               name="product_name"
               placeholder="Enter Product Name"
               required>

        <input type="number"
               name="price"
               placeholder="Enter Price"
               required>

        <input type="file"
               name="image"
               required>

        <button name="save">UPLOAD PRODUCT</button>

    </form>

    <div class="links">

        <a href="admin_view_products.php" class="view-btn">
            📦 View Products
        </a>

        <a href="admin_orders.php" class="back-btn">
            ← Back
        </a>

    </div>

    <div class="footer">
        🌽 Organic Fruits • Fresh Vegetables • Farm Market 🍅
    </div>

</div>

</body>
</html>