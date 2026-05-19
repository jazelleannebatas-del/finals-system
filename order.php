<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $buyer_name = $_POST['buyer_name'];
    $quantity = $_POST['quantity'];

    $conn->query("INSERT INTO orders (product_id, buyer_name, quantity)
                  VALUES ('$product_id', '$buyer_name', '$quantity')");

    echo "Order placed successfully! <a href='products.php'>Back to products</a>";
}
?>