<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['verified'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";

if (isset($_POST['reset'])) {

    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new != $confirm) {
        $message = "Password not match.";
    } else {

        $email = $_SESSION['reset_email'];

        $stmt = $conn->prepare("
            UPDATE users 
            SET password=?, reset_code=NULL 
            WHERE email=?
        ");

        $stmt->bind_param("ss", $new, $email);
        $stmt->execute();

        unset($_SESSION['verified']);
        unset($_SESSION['reset_email']);

        echo "<script>
            alert('Password reset successful!');
            window.location='login.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>

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

<h2>🔁 Reset Password</h2>

<form method="POST">
    <input type="password" name="new_password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button name="reset">Reset</button>
</form>

<p style="color:red;"><?php echo $message; ?></p>

</div>

</body>
</html>