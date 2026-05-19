<?php
$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>GCash Payment</title>

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
    width:380px;
    background:rgba(255,255,255,0.96);
    padding:25px;
    border-radius:18px;
    box-shadow:0 0 25px rgba(0,0,0,0.35);
    text-align:center;
}

/* TITLE */
h2{
    color:#2e7d32;
    margin-bottom:10px;
}

/* ORDER ID */
.order{
    background:#f1f1f1;
    padding:10px;
    border-radius:10px;
    margin:10px 0;
    font-weight:bold;
}

/* GCASH BOX */
.gcash-box{
    background:#00c853;
    color:white;
    padding:15px;
    border-radius:12px;
    margin-top:15px;
}

/* INFO TEXT */
p{
    margin:5px 0;
}

/* BUTTON */
.btn{
    background:#27ae60;
    color:white;
    padding:14px;
    border:none;
    width:100%;
    cursor:pointer;
    border-radius:10px;
    font-weight:bold;
    margin-top:15px;
    transition:0.3s;
}

.btn:hover{
    background:#1e8449;
    transform:scale(1.02);
}

/* ICON */
.icon{
    font-size:45px;
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">💳🌽</div>

    <h2>GCash Payment</h2>

    <div class="order">
        Order ID: #<?php echo $order_id; ?>
    </div>

    <div class="gcash-box">

        <h3>Send Payment To</h3>

        <p><b>GCash Number:</b> 0910 435 6589</p>
        <p><b>Name:</b> Juan Santos</p>

    </div>

    <p style="margin-top:15px;">
        After payment, click confirm below
    </p>

    <form action="view_orders.php" method="POST">

        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

        <button class="btn">✔ I Have Paid</button>

    </form>

</div>

</body>
</html>