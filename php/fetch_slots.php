<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM slots");

echo "<div class='slots-container'>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='slot-card'>";
    echo "<strong>Slot: " . $row['slot_number'] . "</strong>";

    if ($row['is_booked']) {
        echo "<div class='booked'>Booked</div>";
    } else {
        echo "<form action='php/book_slot.php' method='POST'>";
        echo "<input type='hidden' name='slot_id' value='" . $row['id'] . "' />";
        echo "<button type='submit'>Book</button>";
        echo "</form>";
    }

    echo "</div>"; // end slot-card
}

echo "</div>"; // end slots-container

?>
