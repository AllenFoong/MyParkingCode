<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please <a href='../login.html'>login</a> to book.");
}

$user_id = $_SESSION['user_id'];
$slot_id = $_POST['slot_id'];
$time = date('Y-m-d H:i:s');

// Check if already booked
$check = mysqli_query($conn, "SELECT is_booked FROM slots WHERE id='$slot_id'");
$row = mysqli_fetch_assoc($check);

if ($row['is_booked']) {
    echo "Slot already booked. <a href='../dashboard.html'>Go back</a>";
    exit;
}

// Book slot
mysqli_query($conn, "INSERT INTO bookings (user_id, slot_id, booking_time) VALUES ('$user_id', '$slot_id', '$time')");
mysqli_query($conn, "UPDATE slots SET is_booked=1 WHERE id='$slot_id'");

echo "Slot booked successfully! <a href='../dashboard.html'>Back to Dashboard</a>";
?>
