<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Load booking history from JSON file
$bookings = [];
$bookingFile = 'bookings.json';
if (file_exists($bookingFile)) {
    $content = file_get_contents($bookingFile);
    $bookings = json_decode($content, true) ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Smart Parking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #2f2f2f;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .logout {
            float: right;
            background: red;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: -50px;
            margin-right: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .booking-card {
            background: #eee;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }
        .booking-card strong {
            display: inline-block;
            width: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h2>Booking History (Demo Only)</h2>

        <?php if (empty($bookings)): ?>
            <p>No bookings found.</p>
        <?php else: ?>
            <?php foreach ($bookings as $b): ?>
                <div class="booking-card">
                    <p><strong>User:</strong> <?= htmlspecialchars($b['username'] ?? 'Unknown') ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($b['date']) ?></p>
                    <p><strong>Vehicle:</strong> <?= htmlspecialchars($b['vehicle']) ?></p>
                    <p><strong>Duration:</strong> <?= htmlspecialchars($b['duration']) ?></p>
                    <p><strong>Fee:</strong> <?= htmlspecialchars($b['fee']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
