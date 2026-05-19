<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) header("Location: login.php");
$farmer_id = $_SESSION['user_id'];
$id = $_GET['id'];

$result = $conn->query("SELECT * FROM products WHERE id=$id AND farmer_id=$farmer_id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $category = $_POST['category'];

    $conn->query("UPDATE products SET product_name='$name', price='$price', quantity='$qty', category='$category'
                  WHERE id=$id AND farmer_id=$farmer_id");
    header("Location: dashboard.php");
    exit();
}
?>

<form method="POST">
    Product Name: <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" required><br>
    Price: <input type="number" name="price" value="<?php echo $row['price']; ?>" required><br>
    Quantity: <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" required><br>
    Category:
    <select name="category" required>
        <option value="Gulay" <?php if($row['category']=='Gulay') echo 'selected'; ?>>Gulay</option>
        <option value="Prutas" <?php if($row['category']=='Prutas') echo 'selected'; ?>>Prutas</option>
        <option value="Herbs" <?php if($row['category']=='Herbs') echo 'selected'; ?>>Herbs</option>
    </select><br>
    <button type="submit">Update Product</button>
</form>