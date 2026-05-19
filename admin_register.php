<?php
session_start();
require_once "connection.php";

$msg = "";

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password != $confirm) {

        $msg = "Passwords do not match";

    } else {

        $check = mysqli_query(
            $conn,
            "SELECT * FROM admins
             WHERE username='$username'"
        );

        if (mysqli_num_rows($check) > 0) {

            $msg = "Username already exists";

        } else {

            // SAVE NORMAL PASSWORD
            mysqli_query(
                $conn,
                "INSERT INTO admins
                (username, email, password)
                VALUES
                ('$username', '$email', '$password')"
            );

            header("Location: admin_login.php?registered=1");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(
                135deg,
                #2c8340,
                #29813f
            );
        }

        .box {
            background: white;
            width: 400px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #2f8040;
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #256735;
        }

        .msg {
            background: #fff3cd;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #2f8040;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Admin Registration</h2>

    <?php
    if ($msg != "") {
        echo "<div class='msg'>$msg</div>";
    }
    ?>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="Username"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm Password"
            required
        >

        <button name="register">
            Register
        </button>

    </form>

    <br>

    <center>
        <a href="admin_login.php">
            Already have account? Login
        </a>
    </center>

</div>

</body>
</html>