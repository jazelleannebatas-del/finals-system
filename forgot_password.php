<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$conn = new mysqli("localhost", "root", "", "farmers_db");

$message = "";

if (isset($_POST['send'])) {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $code = rand(100000, 999999);

        $update = $conn->prepare("UPDATE users SET reset_code=? WHERE email=?");
        $update->bind_param("ss", $code, $email);
        $update->execute();

        $_SESSION['reset_email'] = $email;

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'guintosopiamae@gmail.com';
            $mail->Password   = 'qftx epfz ucni tgcb';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('guintosopiamae@gmail.com', 'Farmers Market');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Code';

            $mail->Body = "
                <h2>🌽 Farmers Market Reset Code</h2>
                <h1 style='color:#27ae60'>$code</h1>
                <p>Use this code to reset your password</p>
            ";

            $mail->send();

            header("Location: verify_code.php");
            exit();

        } catch (Exception $e) {
            $message = "Email error: {$mail->ErrorInfo}";
        }

    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:
    linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1400')
    no-repeat center center fixed;
    background-size:cover;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    width:380px;
    background:white;
    padding:30px;
    border-radius:15px;
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
    <h2>🌽 Forgot Password</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter email" required>
        <button name="send">Send Code</button>
    </form>

    <p style="color:red;"><?php echo $message; ?></p>
</div>

</body>
</html>