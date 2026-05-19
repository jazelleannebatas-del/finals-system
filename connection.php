<?php

$conn=mysqli_connect(
"localhost",
"root",
"",
"farmers_db"
);

if(!$conn){
die("Database connection failed");
}

?>