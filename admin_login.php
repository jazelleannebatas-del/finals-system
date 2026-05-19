<?php
session_start();
require_once "connection.php";

$error = "";
$success = "";

if (isset($_GET['registered'])) {
    $success = "Registration Successful!";
}

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM admins
         WHERE username='$username'"
    );

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

        // NORMAL PASSWORD CHECK
        if ($password == $admin['password']) {

            $_SESSION['admin'] = true;
            $_SESSION['admin_name'] = $admin['username'];

            header("location:admin_orders.php");
            exit();

        } else {
            $error = "Wrong Password";
        }

    } else {
        $error = "Admin Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: linear-gradient(
                135deg,
                #20834d,
                #3daa74
            );
        }

        .login-box {
            background: white;
            width: 420px;
            padding: 45px;
            border-radius: 22px;

            box-shadow: 0 10px 35px rgba(0, 0, 0, .25);

            text-align: center;
        }

        .logo {
            font-size: 60px;
            margin-bottom: 10px;
        }

        h2 {
            color: #2f884d;
            margin-bottom: 8px;
        }

        .sub {
            color: gray;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .notice {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error {
            background: #fde2e2;
            color: #b00020;
        }

        .success {
            background: #d8f3dc;
            color: #2d6a4f;
        }

        .input-group {
            text-align: left;
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            display: block;
            margin-bottom: 7px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: #40bd50;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
        }

        button:hover {
            background: #3baf4b;
        }

        .register-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: #3fb449;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

<body>

<div class="login-box">

    <div class="logo">
        🛒
    </div>

    <h2>
        Farmers Admin Portal
    </h2>

    <div class="sub">
        Login to manage customer orders
    </div>

    <?php
    if ($error != "") {
        echo "<div class='notice error'>$error</div>";
    }

    if ($success != "") {
        echo "<div class='notice success'>$success</div>";
    }
    ?>

    <form method="POST">

        <div class="input-group">
            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required
            >
        </div>

        <div class="input-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required
            >
        </div>

        <button name="login">
            Login
        </button>

    </form>

    <div class="register-link">
        No Admin Account?

        <a href="admin_register.php">
            Register Here
        </a>
    </div>

    <div class="footer">
        Farmers Ordering System
    </div>

</div>

</body>
</html>