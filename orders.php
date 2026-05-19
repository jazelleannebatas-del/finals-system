<?php
include 'config.php';

$result = $conn->query("SELECT orders.*, products.product_name 
                        FROM orders 
                        JOIN products ON orders.product_id = products.id");
?>

<h2>Orders</h2>

<?php while ($row = $result->fetch_assoc()) { ?>
    <p>
        Product: <?php echo $row['product_name']; ?> <br>
        Buyer: <?php echo $row['buyer_name']; ?> <br>
        Quantity: <?php echo $row['quantity']; ?>
    </p>
<?php } ?>