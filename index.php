<?php
$conn = new mysqli("localhost", "root", "", "farmers_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {

        $message = "Please fill up all fields.";

    } else {

        $stmt = $conn->prepare("
            INSERT INTO users (username, email, password)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {

            echo "
            <script>
                alert('Registered successfully!');
                window.location='login.php';
            </script>
            ";
            exit();

        } else {
            $message = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Farmers Market Register</title>

<style>

body{
    font-family: Arial;
    margin: 0;
    padding: 0;

    /* VEGETABLES & FRUITS FARM BACKGROUND */
    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400') no-repeat center center fixed;

    background-size: cover;
}

.box{
    width: 400px;
    margin: 70px auto;
    background: rgba(255,255,255,0.93);
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,.4);
}

h2{
    text-align: center;
    color: #2e7d32;
    margin-bottom: 25px;
    font-size: 28px;
}

input{
    width: 100%;
    padding: 13px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 7px;
    font-size: 15px;
    box-sizing: border-box;
}

input:focus{
    border-color: green;
    outline: none;
}

button{
    width: 100%;
    padding: 13px;
    background: #43a047;
    color: white;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
    font-weight: bold;
}

button:hover{
    background: #2e7d32;
}

.msg{
    text-align: center;
    margin-top: 15px;
    color: red;
    font-weight: bold;
}

.links{
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
}

.links a{
    color: #1b5e20;
    text-decoration: none;
    font-weight: bold;
}

.links a:hover{
    text-decoration: underline;
}

.footer{
    text-align: center;
    color: white;
    margin-top: 20px;
    font-size: 15px;
    font-weight: bold;
    text-shadow: 1px 1px 4px black;
}

.icon{
    text-align: center;
    font-size: 55px;
    margin-bottom: 10px;
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">🥬🍎🥕</div>

    <h2>Farm Market Register</h2>

    <form method="POST">

        <input type="text" name="username" placeholder="Enter Username" required>

        <input type="email" name="email" placeholder="Enter Email" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit">REGISTER</button>

    </form>

    <div class="msg">
        <?php echo $message; ?>
    </div>

    <div class="links">

        <p>
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

</div>

<div class="footer">
    🌽 Fresh Fruits • Organic Vegetables • Farm Products 🍅
</div>

</body>
</html>