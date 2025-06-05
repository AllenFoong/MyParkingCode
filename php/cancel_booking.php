<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$booking_id = $_POST['booking_id'];

// Confirm this booking belongs to the user
$booking = mysqli_query($conn, "SELECT slot_id FROM bookings WHERE id = $booking_id AND user_id = " . $_SESSION['user_id']);
if (mysqli_num_rows($booking) === 0) {
    die("Invalid booking or permission denied.");
}

$data = mysqli_fetch_assoc($booking);
$slot_id = $data['slot_id'];

// Delete the booking
mysqli_query($conn, "DELETE FROM bookings WHERE id = $booking_id");

// Mark the slot as available
mysqli_query($conn, "UPDATE slots SET is_booked = 0 WHERE id = $slot_id");

// Redirect back to history
header("Location: ../booking_history.html");
?>
