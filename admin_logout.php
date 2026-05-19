<?php
session_start();

/* remove admin session only */
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_id']);

/* wag session_destroy para di maapektuhan user session */
header("Location: admin_login.php");
exit();
?>