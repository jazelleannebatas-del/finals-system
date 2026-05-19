<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

/* DELETE PRODUCT */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

    header("location:admin_view_products.php");
    exit();
}

/* GET PRODUCTS */
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Products List</title>

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
    padding:40px;

    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;
}

/* MAIN CONTAINER */
.container{
    width:95%;
    max-width:1100px;
    margin:auto;
    background:rgba(255,255,255,0.96);
    padding:30px;
    border-radius:18px;
    box-shadow:0 0 25px rgba(0,0,0,0.35);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

h2{
    color:#2e7d32;
    font-size:32px;
}

/* ADD BUTTON */
.add-btn{
    background:#43a047;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.add-btn:hover{
    background:#2e7d32;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:12px;
}

table th{
    background:#43a047;
    color:white;
    padding:15px;
    text-align:center;
    font-size:16px;
}

table td{
    padding:15px;
    text-align:center;
    background:white;
    border-bottom:1px solid #ddd;
}

table tr:hover{
    background:#f5f5f5;
}

/* PRODUCT IMAGE */
.product-img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #43a047;
}

/* PRICE */
.price{
    color:#2e7d32;
    font-weight:bold;
    font-size:18px;
}

/* ACTION BUTTONS */
.action-btn{
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-weight:bold;
    margin:3px;
    display:inline-block;
    transition:0.3s;
}

/* EDIT */
.edit-btn{
    background:#3498db;
}

.edit-btn:hover{
    background:#217dbb;
}

/* DELETE */
.delete-btn{
    background:#e74c3c;
}

.delete-btn:hover{
    background:#c0392b;
}

/* BACK BUTTON */
.back{
    margin-top:25px;
    text-align:center;
}

.back-btn{
    display:inline-block;
    background:#e67e22;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.back-btn:hover{
    background:#ca6b17;
}

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

<div class="container">

    <div class="header">

        <h2>🥬 Products List</h2>

        <a href="admin_add_product.php" class="add-btn">
            + Add Product
        </a>

    </div>

    <table>

        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        <?php while($p = mysqli_fetch_assoc($products)) { ?>

        <tr>

            <td>
                <img src="uploads/<?php echo $p['image']; ?>"
                     class="product-img">
            </td>

            <td>
                <?php echo $p['product_name']; ?>
            </td>

            <td class="price">
                ₱<?php echo $p['price']; ?>
            </td>

            <td>

                <a href="admin_edit_product.php?id=<?php echo $p['id']; ?>"
                   class="action-btn edit-btn">
                   ✏ Edit
                </a>

                <a href="?delete=<?php echo $p['id']; ?>"
                   class="action-btn delete-btn"
                   onclick="return confirm('Delete product?')">
                   🗑 Delete
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

    <div class="back">

        <a href="admin_add_product.php" class="back-btn">
            ← Back
        </a>

    </div>

    <div class="footer">
        🌽 Organic Fruits • Fresh Vegetables • Farm Market 🍅
    </div>

</div>

</body>
</html>