<?php
$host = "sql103.infinityfree.com";
$username = "if0_39504394";
$password = "Loong314159";
$database = "if0_39504394_CarParkingBooking";

$conn = mysqli_connect($host, $username, $password, $database);

// Debug用：如果连接失败会直接显示错误
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

