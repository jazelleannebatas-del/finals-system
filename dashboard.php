<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? "Customer";

/* CART SESSION */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ADD TO CART */
if (isset($_POST['add_cart'])) {

    $id = (int)$_POST['product_id'];
    $qty = (int)$_POST['qty'];

    if ($qty < 1) $qty = 1;

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);

    if ($product) {

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                "name"  => $product['product_name'],
                "price" => $product['price'],
                "qty"   => $qty
            ];
        }
    }

    header("Location: dashboard.php");
    exit();
}

/* REMOVE ITEM */
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: dashboard.php");
    exit();
}

/* PRODUCTS */
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

if (!$products) {
    die("SQL ERROR: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Farmers Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* 🌽 BACKGROUND */
body{
    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;
    min-height:100vh;
}

/* HEADER */
.header{
    background:rgba(39,174,96,0.95);
    color:white;
    padding:25px;
    text-align:center;
    position:relative;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

.header h2{
    font-size:28px;
}

.header div{
    margin-top:5px;
    font-size:14px;
}

/* NAV BUTTONS */
.nav{
    position:absolute;
    top:20px;
    text-decoration:none;
    padding:10px 15px;
    border-radius:10px;
    font-weight:bold;
    color:white;
    transition:0.3s;
}

.nav:hover{
    transform:scale(1.05);
}

.left{ left:20px; background:#2980b9; }
.middle{ left:160px; background:#f39c12; }
.right{ right:20px; background:#e74c3c; }

/* MAIN CONTAINER */
.container{
    display:flex;
    gap:20px;
    padding:25px;
    max-width:1300px;
    margin:auto;
}

/* PRODUCTS */
.products{
    width:70%;
}

.products h3{
    color:white;
    margin-bottom:15px;
    text-shadow:1px 1px 4px black;
}

/* GRID */
.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));
    gap:15px;
}

/* PRODUCT CARD */
.card{
    background:rgba(255,255,255,0.95);
    border-radius:15px;
    padding:15px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* IMAGE */
.card img{
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:12px;
    border:2px solid #ddd;
}

/* TEXT */
.card h4{
    margin:10px 0 5px;
    font-size:14px;
}

.price{
    color:#2e7d32;
    font-weight:bold;
    margin-bottom:10px;
}

/* INPUT */
.card input{
    width:100%;
    padding:8px;
    border-radius:8px;
    border:1px solid #ccc;
    margin-bottom:8px;
}

/* BUTTON */
.btn{
    width:100%;
    padding:10px;
    background:#27ae60;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#1e8449;
}

/* CART */
.cart{
    width:30%;
    background:rgba(255,255,255,0.95);
    padding:20px;
    border-radius:15px;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
    height:fit-content;
}

.cart h3{
    margin-bottom:15px;
    color:#2e7d32;
}

/* CART ITEM */
.item{
    background:#f7f7f7;
    padding:10px;
    border-radius:10px;
    margin-bottom:10px;
}

/* TOTAL */
.total{
    font-size:22px;
    color:#2e7d32;
    font-weight:bold;
    margin-top:10px;
}

/* CHECKOUT BUTTON */
.checkout-btn{
    margin-top:15px;
    width:100%;
    padding:12px;
    background:#2e7d32;
    color:white;
    border:none;
    border-radius:10px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.checkout-btn:hover{
    background:#1b5e20;
}

/* EMPTY */
.empty{
    text-align:center;
    color:#555;
    font-weight:bold;
}

/* FOOTER */
.footer{
    text-align:center;
    color:white;
    margin-top:20px;
    font-weight:bold;
    text-shadow:1px 1px 4px black;
}

</style>

</head>

<body>

<div class="header">

    <a href="view_orders.php" class="nav left">📦 Orders</a>
    <a href="change_password.php" class="nav middle">🔒 Password</a>
    <a href="logout.php" class="nav right">🚪 Logout</a>

    <h2>🌾 Farmers Shop Dashboard</h2>
    <div>Welcome, <?php echo $username; ?> 👋</div>

</div>

<div class="container">

<!-- PRODUCTS -->
<div class="products">

<h3>🛍 Fresh Farm Products</h3>

<div class="product-grid">

<?php while ($p = mysqli_fetch_assoc($products)) { ?>

<div class="card">

    <img src="uploads/<?php echo $p['image']; ?>">

    <h4><?php echo $p['product_name']; ?></h4>

    <div class="price">₱<?php echo number_format($p['price'], 2); ?></div>

    <form method="POST">

        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">

        <input type="number" name="qty" value="1" min="1">

        <button class="btn" name="add_cart">🛒 Add To Cart</button>

    </form>

</div>

<?php } ?>

</div>

</div>

<!-- CART -->
<div class="cart">

<h3>🛒 My Cart</h3>

<?php
$total = 0;

if (!empty($_SESSION['cart'])) {

foreach ($_SESSION['cart'] as $key => $item) {

$subtotal = $item['price'] * $item['qty'];
$total += $subtotal;
?>

<div class="item">

<b><?php echo $item['name']; ?></b><br>
Qty: <?php echo $item['qty']; ?><br>
₱<?php echo number_format($subtotal, 2); ?><br>

</div>

<?php } ?>

<div class="total">
Total: ₱<?php echo number_format($total, 2); ?>
</div>

<form action="checkout.php" method="POST">
    <button class="checkout-btn">✅ Place Order</button>
</form>

<?php } else { ?>

<p class="empty">Cart is empty 🛒</p>

<?php } ?>

</div>

</div>

<div class="footer">
🌽 Organic Fruits • Fresh Vegetables • Farm Market 🍅
</div>

</body>
</html>