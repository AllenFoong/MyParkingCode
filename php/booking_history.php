<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please <a href='../login.html'>login</a> to view your booking history.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user email
$user_query = mysqli_query($conn, "SELECT email FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);
$user_email = $user_data['email'];

// Get booking history (latest first)
$query = "SELECT b.id AS booking_id, s.slot_number, b.booking_time 
          FROM bookings b
          JOIN slots s ON b.slot_id = s.id
          WHERE b.user_id = $user_id
          ORDER BY b.booking_time DESC";

$result = mysqli_query($conn, $query);

// Display email
echo "<p><strong>Email:</strong> " . htmlspecialchars($user_email) . "</p>";

if (mysqli_num_rows($result) === 0) {
    echo "You have no bookings yet.";
} else {
    echo "<table border='1' style='margin:auto; border-collapse:collapse;'>";
    echo "<tr><th>Slot</th><th>Booking Time</th><th>Action</th></tr>";

    $first = true;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['slot_number']) . "</td>";
        echo "<td>" . $row['booking_time'] . "</td>";
        echo "<td>";
        if ($first) {
            echo "<form action='/php/cancel_booking.php' method='POST'>
                    <input type='hidden' name='booking_id' value='" . $row['booking_id'] . "'>
                    <button type='submit'>Cancel</button>
                  </form>";
            $first = false; // Only first (latest) gets cancel button
        } else {
            echo "-";
        }
        echo "</td></tr>";
    }

    echo "</table>";
}
?>
