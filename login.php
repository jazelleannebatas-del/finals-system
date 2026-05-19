<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";

    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $password === $user['password']) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Farmers Login</title>

<style>

/* 🌽 VEGETABLE & FRUIT MARKET BACKGROUND */
body{
    margin:0;
    font-family:Arial;

    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;

    background-size:cover;

    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* LOGIN BOX */
.box{
    width:380px;
    background:rgba(255,255,255,0.92);
    padding:35px;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,0.4);
    text-align:center;
}

/* TITLE */
h2{
    color:#2e7d32;
    margin-bottom:20px;
    font-size:30px;
}

/* ICON */
.icon{
    font-size:55px;
    margin-bottom:10px;
}

/* INPUTS */
input{
    width:100%;
    padding:13px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
    outline:none;
    font-size:15px;
    box-sizing:border-box;
}

input:focus{
    border-color:green;
}

/* BUTTON */
button{
    width:100%;
    padding:13px;
    background:#43a047;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
    transition:0.3s;
}

button:hover{
    background:#2e7d32;
}

/* ERROR MESSAGE */
.msg{
    color:red;
    margin-top:10px;
    font-weight:bold;
}

/* LINKS */
.links{
    margin-top:18px;
    font-size:14px;
}

.links a{
    color:#1b5e20;
    text-decoration:none;
    font-weight:bold;
}

.links a:hover{
    text-decoration:underline;
}

/* FOOTER */
.footer{
    position:absolute;
    bottom:15px;
    color:white;
    font-size:15px;
    font-weight:bold;
    text-shadow:1px 1px 4px black;
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">🥬🍎🥕</div>

    <h2>Farmers Login</h2>

    <form method="POST">

        <input type="email" name="email" placeholder="Enter Email" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit">LOGIN</button>

    </form>

    <div class="msg">
        <?php echo $message; ?>
    </div>

    <div class="links">

        <p>
            <a href="forgot_password.php">Forgot Password?</a>
        </p>

        <p>
            Don't have an account?
            <a href="index.php">Register here</a>
        </p>

    </div>

</div>

<div class="footer">
    🌽 Fresh Fruits • Organic Vegetables • Farm Products 🍅
</div>

</body>
</html>