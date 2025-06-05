<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM slots");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='margin:10px;'>";
    echo "Slot: " . $row['slot_number'] . " - " . ($row['is_booked'] ? "Booked" : "Available");
    echo "</div>";
}
?>

