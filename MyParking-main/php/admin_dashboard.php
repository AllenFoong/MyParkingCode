<?php
session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit();
}

// DB Connection
$host = "sql206.infinityfree.com";
$username = "if0_39517079";
$password = "ebooking123";
$database = "if0_39517079_ebooking_db";
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch registered users
$user_sql = "SELECT id, username, email FROM users";
$user_result = $conn->query($user_sql);

// Check if query was successful
if (!$user_result) {
    die("Error fetching users: " . $conn->error);
}

// Booking JSON
$bookings = [];
$bookingFile = 'bookings.json'; // adjust path if needed
if (file_exists($bookingFile)) {
    $bookings = json_decode(file_get_contents($bookingFile), true) ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
            font-size: 28px;
            font-weight: bold;
        }

        .logout {
            float: right;
            background: red;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 4px;
            //margin-top: -50px;
            margin-right: 20px;
            font-size: 16px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        /* Table for Registered Users */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-bottom: 40px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background: #444;
            color: white;
        }

        /* Booking card section */
        .booking-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .booking-card {
            background: #f1f1f1;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .booking-card strong {
            display: inline-block;
            width: 90px;
        }
    </style>
</head>
<body>
    <div class="header">
        Admin Dashboard
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h2>Registered Users</h2>
        <?php if ($user_result && $user_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php while($row = $user_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>

        <div class="booking-section">
            <h2>Booking History</h2>
            <?php if (empty($bookings)): ?>
                <p>No bookings found.</p>
            <?php else: ?>
                <?php foreach ($bookings as $b): ?>
                    <div class="booking-card">
                        <p><strong>User:</strong> <?= htmlspecialchars($b['username'] ?? 'Unknown') ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($b['date'] ?? '-') ?></p>
                        <p><strong>Vehicle:</strong> <?= htmlspecialchars($b['vehicle'] ?? '-') ?></p>
                        <p><strong>Duration:</strong> <?= htmlspecialchars($b['duration'] ?? '-') ?></p>
                        <p><strong>Fee:</strong> <?= htmlspecialchars($b['fee'] ?? '-') ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
