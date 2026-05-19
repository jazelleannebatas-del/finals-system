<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

/* APPROVE */
if (isset($_GET['approve'])) {

    $id = intval($_GET['approve']);

    mysqli_query($conn,
        "UPDATE orders
         SET approval_status='Approved',
             status='Preparing'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* REJECT */
if (isset($_GET['reject'])) {

    $id = intval($_GET['reject']);

    mysqli_query($conn,
        "UPDATE orders
         SET approval_status='Rejected',
             status='Cancelled'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* OUT FOR DELIVERY */
if (isset($_GET['deliver'])) {

    $id = intval($_GET['deliver']);

    mysqli_query($conn,
        "UPDATE orders
         SET status='Out for Delivery'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* DELIVERED */
if (isset($_GET['done'])) {

    $id = intval($_GET['done']);

    mysqli_query($conn,
        "UPDATE orders
         SET status='Delivered'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* GET ORDERS */
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");

if (!$orders) {
    die("Fetch Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Orders</title>

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
    linear-gradient(rgba(0,0,0,0.50), rgba(0,0,0,0.50)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:240px;
    height:100%;
    background:rgba(34,49,34,0.95);
    padding-top:30px;
    box-shadow:2px 0 15px rgba(0,0,0,0.3);
}

.sidebar h2{
    color:white;
    text-align:center;
    margin-bottom:35px;
    font-size:28px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
    margin:8px 15px;
    border-radius:10px;
    transition:0.3s;
    font-weight:bold;
}

.sidebar a:hover{
    background:#43a047;
    transform:translateX(5px);
}

/* MAIN */
.main{
    margin-left:260px;
    padding:35px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.96);
    border-radius:20px;
    padding:30px;
    box-shadow:0 0 25px rgba(0,0,0,0.35);
}

/* TITLE */
.title h2{
    color:#2e7d32;
    font-size:35px;
    margin-bottom:25px;
}

/* ORDER BOX */
.order-box{
    background:#fff;
    border-radius:18px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
    border-left:8px solid #43a047;
}

/* ORDER TOP */
.order-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.order-id{
    font-size:24px;
    color:#2e7d32;
    font-weight:bold;
}

/* INFO GRID */
.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.info{
    background:#f7f7f7;
    padding:15px;
    border-radius:12px;
}

.info b{
    color:#2e7d32;
}

/* PAYMENT */
.payment{
    background:#2c3e50;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

/* STATUS */
.status{
    padding:7px 14px;
    border-radius:20px;
    color:white;
    font-size:12px;
    font-weight:bold;
}

.pending{ background:#f39c12; }
.approved{ background:#27ae60; }
.rejected{ background:#e74c3c; }
.preparing{ background:#3498db; }
.delivery{ background:#8e44ad; }
.delivered{ background:#16a085; }
.cancelled{ background:#c0392b; }

/* ITEMS */
.items{
    background:#f9f9f9;
    padding:18px;
    border-radius:15px;
    margin-top:15px;
}

.items h3{
    color:#2e7d32;
    margin-bottom:15px;
}

/* ITEM */
.item{
    display:flex;
    justify-content:space-between;
    background:white;
    padding:12px 15px;
    border-radius:10px;
    margin-bottom:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.08);
}

.item-name{
    font-weight:bold;
    color:#333;
}

.item-price{
    color:#2e7d32;
    font-weight:bold;
}

/* BUTTONS */
.actions{
    margin-top:20px;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    margin:5px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    font-size:13px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.05);
}

.approve-btn{ background:#27ae60; }
.reject-btn{ background:#e74c3c; }
.delivery-btn{ background:#3498db; }
.done-btn{ background:#8e44ad; }

/* FOOTER */
.footer{
    text-align:center;
    margin-top:25px;
    color:#555;
    font-size:14px;
    font-weight:bold;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>🥬 Admin Panel</h2>

    <a href="admin_add_product.php">
        ➕ Add Products
    </a>

    <a href="admin_logout.php">
        🚪 Logout
    </a>

</div>

<!-- MAIN -->
<div class="main">

<div class="card">

    <div class="title">
        <h2>🌽 Customer Orders</h2>
    </div>

    <?php while ($row = mysqli_fetch_assoc($orders)) { ?>

    <?php
        $approval = $row['approval_status'];
        $status = $row['status'];
    ?>

    <!-- ORDER CARD -->
    <div class="order-box">

        <div class="order-top">

            <div class="order-id">
                🧾 Order #<?php echo $row['id']; ?>
            </div>

            <div>

                <span class="payment">
                    <?php echo $row['payment_method'] ?? 'COD'; ?>
                </span>

                <span class="status <?php
                    if ($status == 'Preparing') echo 'preparing';
                    elseif ($status == 'Out for Delivery') echo 'delivery';
                    elseif ($status == 'Delivered') echo 'delivered';
                    elseif ($status == 'Cancelled') echo 'cancelled';
                    else echo 'pending';
                ?>">
                    <?php echo $status; ?>
                </span>

            </div>

        </div>

        <!-- CUSTOMER INFO -->
        <div class="info-grid">

            <div class="info">
                <b>👤 Buyer</b><br>
                <?php echo $row['fullname']; ?>
            </div>

            <div class="info">
                <b>📞 Contact</b><br>
                <?php echo $row['contact']; ?>
            </div>

            <div class="info">
                <b>📍 Address</b><br>
                <?php echo $row['address']; ?>
            </div>

            <div class="info">
                <b>💰 Total</b><br>
                ₱<?php echo number_format($row['total'], 2); ?>
            </div>

        </div>

        <!-- ORDER ITEMS -->
        <div class="items">

            <h3>🛒 Ordered Items</h3>

            <?php

            $order_id = $row['id'];

            $items = mysqli_query($conn,
                "SELECT * FROM order_items
                 WHERE order_id='$order_id'"
            );

            if ($items && mysqli_num_rows($items) > 0) {

                while ($item = mysqli_fetch_assoc($items)) {
            ?>

                <div class="item">

                    <div class="item-name">
                        <?php echo $item['product_name']; ?>
                        × <?php echo $item['qty']; ?>
                    </div>

                    <div class="item-price">
                        ₱<?php echo number_format($item['subtotal'], 2); ?>
                    </div>

                </div>

            <?php
                }

            } else {

                echo "<p>No items found.</p>";
            }

            ?>

        </div>

        <!-- ACTION BUTTONS -->
        <div class="actions">

            <?php if ($approval == "Pending Approval") { ?>

                <a class="btn approve-btn"
                   href="?approve=<?php echo $row['id']; ?>">
                    ✔ Approve
                </a>

                <a class="btn reject-btn"
                   href="?reject=<?php echo $row['id']; ?>">
                    ✖ Reject
                </a>

            <?php } ?>

            <?php if ($status == "Preparing") { ?>

                <a class="btn delivery-btn"
                   href="?deliver=<?php echo $row['id']; ?>">
                    🚚 Out for Delivery
                </a>

            <?php } ?>

            <?php if ($status == "Out for Delivery") { ?>

                <a class="btn done-btn"
                   href="?done=<?php echo $row['id']; ?>">
                    ✅ Delivered
                </a>

            <?php } ?>

        </div>

    </div>

    <?php } ?>

    <div class="footer">
        🌽 Organic Fruits • Fresh Vegetables • Farm Market 🍅
    </div>

</div>

</div>

</body>
</html>