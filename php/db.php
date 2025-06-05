<?php
$conn = mysqli_connect("sql308.infinityfree.com", "if0_39118857", "myparking123", "if0_39118857_parkingdb");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
