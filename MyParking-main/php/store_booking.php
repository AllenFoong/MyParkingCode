<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if ($data && isset($_SESSION['username'])) {
    $file = 'bookings.json';

    // Read existing data
    $bookings = [];
    if (file_exists($file)) {
        $bookings = json_decode(file_get_contents($file), true) ?? [];
    }

    // Add new booking with session data
    $newBooking = [
        "username" => $_SESSION['username'],
        "vehicle" => $data['vehicle'] ?? null,
        "duration" => $data['duration'] ?? null,
        "fee"     => $data['fee'] ?? null,
        "date"    => date("Y-m-d H:i:s")
    ];

    $bookings[] = $newBooking;

    // Save back to file
    file_put_contents($file, json_encode($bookings, JSON_PRETTY_PRINT));
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request or session"]);
}
