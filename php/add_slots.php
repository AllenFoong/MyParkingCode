<?php
session_start();
include 'db.php';

// For demo, no admin validation
$slot_number = $_POST['slot_number'];
mysqli_query($conn, "INSERT INTO slots (slot_number) VALUES ('$slot_number')");
header("Location: ../admin.html");
?>
