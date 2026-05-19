<?php
require_once "connection.php";

$id = $_GET['id'];

$order = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM orders
         WHERE id='$id'"
    )
);

$status   = $order['status'];
$approval = $order['approval_status'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Order</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 70%;
            margin: 50px auto;
        }

        .card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        }

        .btn {
            display: inline-block;
            background: #2c3e50;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .notice {
            background: #d4edda;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }

        .pending {
            background: #fff3cd;
        }

        .timeline {
            margin-top: 30px;
        }

        .step {
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #ddd;
            background: #fafafa;
        }

        .active {
            border-left: 5px solid #27ae60;
            background: #eafaf1;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>
        Track Order #<?php echo $id; ?>
    </h1>
</div>

<div class="container">

    <a href="view_orders.php" class="btn">
        ← Back to View Orders
    </a>

    <div class="card">

        <h3>
            Approval Status: <?php echo $approval; ?>
        </h3>

        <?php if ($approval == "Pending Approval") { ?>
            <div class="notice pending">
                Waiting for admin approval.
            </div>
        <?php } ?>

        <?php if ($approval == "Approved") { ?>
            <div class="notice">
                ✅ Your order has been approved.
            </div>
        <?php } ?>

        <?php if ($approval == "Rejected") { ?>
            <div class="notice pending">
                ❌ Order was rejected.
            </div>
        <?php } ?>

        <p>
            <b>Delivery Status:</b>
            <?php echo $status; ?>
        </p>

        <p>
            <b>Expected Delivery:</b>
            <?php
            echo !empty($order['delivery_date'])
                ? $order['delivery_date']
                : "3 Days";
            ?>
        </p>

        <div class="timeline">

            <div class="step
                <?php
                if (
                    $status == "Pending" ||
                    $status == "Preparing" ||
                    $status == "Out for Delivery" ||
                    $status == "Delivered"
                ) echo "active";
                ?>
            ">
                Order Received
            </div>

            <div class="step
                <?php
                if (
                    $status == "Preparing" ||
                    $status == "Out for Delivery" ||
                    $status == "Delivered"
                ) echo "active";
                ?>
            ">
                Preparing Order
            </div>

            <div class="step
                <?php
                if (
                    $status == "Out for Delivery" ||
                    $status == "Delivered"
                ) echo "active";
                ?>
            ">
                Out For Delivery
            </div>

            <div class="step
                <?php
                if ($status == "Delivered") echo "active";
                ?>
            ">
                Delivered
            </div>

        </div>

    </div>

</div>

</body>
</html>