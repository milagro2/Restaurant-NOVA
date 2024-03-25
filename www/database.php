<?php
$host  = "mariadb";
$dbuser = "root";
$dbpass = "password";
$dbname = "restaurant_nova";

$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
mysqli_set_charset($conn, "utf8mb4");
