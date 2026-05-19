<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

$orders = $conn->query("
    SELECT * FROM orders
    WHERE user_id='$user_id'
    ORDER BY id DESC
");

if (!$orders) {
    die("DB Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>My Orders</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* 🌽 BACKGROUND */
body{
    min-height:100vh;
    padding:30px;

    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;
}

/* CONTAINER */
.container{
    max-width:1100px;
    margin:auto;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

/* TITLE */
.title{
    color:white;
    font-size:38px;
    text-shadow:2px 2px 6px rgba(0,0,0,0.5);
}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    padding:12px 20px;
    background:#43a047;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.back-btn:hover{
    background:#2e7d32;
    transform:scale(1.05);
}

/* ORDER CARD */
.order-box{
    background:rgba(255,255,255,0.96);
    padding:25px;
    margin-bottom:25px;
    border-radius:18px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
    transition:0.3s;
}

.order-box:hover{
    transform:translateY(-3px);
}

/* ORDER TOP */
.order-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
    flex-wrap:wrap;
}

/* ORDER ID */
.order-id{
    font-size:22px;
    color:#2e7d32;
    font-weight:bold;
}

/* STATUS */
.status{
    display:inline-block;
    padding:8px 14px;
    border-radius:20px;
    color:white;
    font-weight:bold;
    font-size:13px;
}

/* STATUS COLORS */
.pending{ background:#f39c12; }
.preparing{ background:#3498db; }
.delivery{ background:#8e44ad; }
.delivered{ background:#27ae60; }
.cancelled{ background:#e74c3c; }

/* PAYMENT */
.payment{
    display:inline-block;
    padding:7px 14px;
    border-radius:20px;
    background:#2c3e50;
    color:white;
    font-weight:bold;
    font-size:13px;
}

/* INFO */
.info{
    margin-top:10px;
    line-height:1.9;
    color:#333;
}

/* TOTAL */
.total{
    color:#2e7d32;
    font-size:20px;
    font-weight:bold;
}

/* ITEMS BOX */
.items{
    background:#f9f9f9;
    padding:18px;
    border-radius:12px;
    margin-top:20px;
    border-left:5px solid #43a047;
}

/* ITEMS TITLE */
.items h4{
    color:#2e7d32;
    margin-bottom:12px;
}

/* ITEM */
.item{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1px solid #ddd;
    color:#444;
}

.item:last-child{
    border-bottom:none;
}

/* FOOTER */
.footer{
    text-align:center;
    color:white;
    margin-top:25px;
    font-weight:bold;
    text-shadow:1px 1px 4px black;
}

</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <h1 class="title">📦 My Orders</h1>

        <a href="dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

    <!-- ORDERS -->
    <?php while ($order = $orders->fetch_assoc()) { ?>

    <?php
    $status = $order['status'] ?? 'Pending';

    $class = "pending";

    if ($status == "Preparing") $class = "preparing";
    if ($status == "Out for Delivery") $class = "delivery";
    if ($status == "Delivered") $class = "delivered";
    if ($status == "Cancelled") $class = "cancelled";

    $payment = $order['payment_method'] ?? 'COD';
    ?>

    <div class="order-box">

        <!-- ORDER TOP -->
        <div class="order-top">

            <div class="order-id">
                🛒 Order #<?php echo $order['id']; ?>
            </div>

            <span class="status <?php echo $class; ?>">
                <?php echo $status; ?>
            </span>

        </div>

        <!-- ORDER INFO -->
        <div class="info">

            <p>
                <b>👤 Name:</b>
                <?php echo htmlspecialchars($order['fullname']); ?>
            </p>

            <p>
                <b>📍 Address:</b>
                <?php echo htmlspecialchars($order['address']); ?>
            </p>

            <p>
                <b>📞 Contact:</b>
                <?php echo htmlspecialchars($order['contact']); ?>
            </p>

            <p>
                <b>💳 Payment:</b>
                <span class="payment">
                    <?php echo $payment; ?>
                </span>
            </p>

            <p class="total">
                💰 Total:
                ₱<?php echo number_format($order['total'], 2); ?>
            </p>

            <p>
                <b>📅 Date:</b>
                <?php echo $order['created_at']; ?>
            </p>

        </div>

        <!-- ITEMS -->
        <div class="items">

            <h4>🥬 Ordered Items</h4>

            <?php
            $order_id = (int)$order['id'];

            $items = $conn->query("
                SELECT * FROM order_items
                WHERE order_id='$order_id'
            ");

            if ($items && $items->num_rows > 0) {

                while ($item = $items->fetch_assoc()) {
            ?>

            <div class="item">

                <span>
                    <?php echo $item['product_name']; ?>
                    × <?php echo $item['qty']; ?>
                </span>

                <span>
                    ₱<?php echo number_format($item['subtotal'], 2); ?>
                </span>

            </div>

            <?php
                }

            } else {

                echo "<p>No items found.</p>";
            }
            ?>

        </div>

    </div>

    <?php } ?>

    <div class="footer">
        🌽 Organic Fruits • Fresh Vegetables • Farm Market 🍅
    </div>

</div>

</body>
</html>