<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";

if (isset($_POST['verify'])) {

    $code = trim($_POST['code']);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND reset_code=?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['verified'] = true;
        header("Location: reset_password.php");
        exit();

    } else {
        $message = "Invalid code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify Code</title>

<style>
body{
    font-family:Arial;
    background:
    linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center/cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    background:white;
    padding:30px;
    border-radius:15px;
    width:350px;
    text-align:center;
}

input, button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:8px;
}

button{
    background:#27ae60;
    color:white;
    border:none;
}
</style>
</head>

<body>

<div class="box">

<h2>🔐 Verify Code</h2>

<form method="POST">
    <input type="text" name="code" placeholder="Enter code" required>
    <button name="verify">Verify</button>
</form>

<p style="color:red;"><?php echo $message; ?></p>

</div>

</body>
</html>