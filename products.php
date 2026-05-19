<?php
include 'config.php';

$category = isset($_GET['category']) ? $_GET['category'] : "";
$search = isset($_GET['search']) ? $_GET['search'] : "";

$sql = "SELECT products.*, users.name AS farmer_name 
        FROM products 
        JOIN users ON products.farmer_id = users.id 
        WHERE 1 ";

if ($category != "") $sql .= " AND category='$category'";
if ($search != "") $sql .= " AND product_name LIKE '%$search%'";

$result = $conn->query($sql);
?>

<h2>Products</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Search product" value="<?php echo $search; ?>">
    <select name="category">
        <option value="">All</option>
        <option value="Gulay" <?php if($category=='Gulay') echo 'selected'; ?>>Gulay</option>
        <option value="Prutas" <?php if($category=='Prutas') echo 'selected'; ?>>Prutas</option>
        <option value="Herbs" <?php if($category=='Herbs') echo 'selected'; ?>>Herbs</option>
    </select>
    <button type="submit">Filter</button>
</form>

<?php while ($row = $result->fetch_assoc()) { ?>
    <div style="border:1px solid black; margin:10px; padding:10px;">
        <h3><?php echo $row['product_name']; ?> (<?php echo $row['category']; ?>)</h3>
        <p>Price: ₱<?php echo $row['price']; ?></p>
        <p>Quantity: <?php echo $row['quantity']; ?></p>
        <p>Farmer: <?php echo $row['farmer_name']; ?></p>

        <form method="POST" action="order.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="number" name="quantity" placeholder="Qty" required>
            <input type="text" name="buyer_name" placeholder="Your Name" required>
            <button type="submit">Order</button>
        </form>
    </div>
<?php } ?>