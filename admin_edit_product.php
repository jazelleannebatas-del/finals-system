<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

$id = $_GET['id'];

$product = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM products WHERE id='$id'")
);

if (isset($_POST['update'])) {

    $name  = $_POST['product_name'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];
        $tmp   = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "uploads/" . $image);

        mysqli_query($conn,
            "UPDATE products
             SET product_name='$name',
                 price='$price',
                 image='$image'
             WHERE id='$id'"
        );

    } else {

        mysqli_query($conn,
            "UPDATE products
             SET product_name='$name',
                 price='$price'
             WHERE id='$id'"
        );
    }

    header("location:admin_view_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Product</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* 🌽 BACKGROUND */
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

/* CONTAINER */
.container{
    width:430px;
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

/* IMAGE PREVIEW */
.preview{
    text-align:center;
    margin-bottom:20px;
}

.preview img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:12px;
    border:3px solid #43a047;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
}

/* BUTTONS */
.btn-group{
    display:flex;
    gap:10px;
}

/* UPDATE BUTTON */
.update-btn{
    flex:1;
    padding:14px;
    background:#43a047;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.update-btn:hover{
    background:#2e7d32;
    transform:scale(1.02);
}

/* BACK BUTTON */
.back-btn{
    flex:1;
    text-align:center;
    padding:14px;
    background:#e67e22;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    transition:0.3s;
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

    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text"
               name="product_name"
               value="<?php echo $product['product_name']; ?>"
               required>

        <input type="number"
               name="price"
               value="<?php echo $product['price']; ?>"
               required>

        <div class="preview">
            <img src="uploads/<?php echo $product['image']; ?>">
        </div>

        <input type="file" name="image">

        <div class="btn-group">

            <button class="update-btn" name="update">
                ✅ Update
            </button>

            <a href="admin_view_products.php" class="back-btn">
                ← Back
            </a>

        </div>

    </form>

    <div class="footer">
        🌽 Organic Fruits • Fresh Vegetables • Farm Market 🍅
    </div>

</div>

</body>
</html>