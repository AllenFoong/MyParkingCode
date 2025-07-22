<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch users
$users = $conn->query("SELECT id, email FROM users");

// Fetch bookings
$bookings = $conn->query("SELECT * FROM bookings");

// Fetch vehicles
$vehicles = $conn->query("SELECT * FROM vehicles");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Smart Parking</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f4f4f4; }
        .header { background: #333; color: white; padding: 15px; text-align: center; }
        .container { padding: 20px; }
        h2 { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .logout { float: right; background: red; color: white; padding: 6px 12px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h2>All Users</h2>
        <table>
            <tr><th>ID</th><th>Email</th></tr>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr><td><?= $user['id'] ?></td><td><?= $user['email'] ?></td></tr>
            <?php endwhile; ?>
        </table>

        <h2>All Bookings</h2>
        <table>
            <tr><th>ID</th><th>User ID</th><th>Location</th><th>Start</th><th>End</th></tr>
            <?php while ($b = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= $b['user_id'] ?></td>
                    <td><?= $b['location'] ?></td>
                    <td><?= $b['start_time'] ?></td>
                    <td><?= $b['end_time'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>All Registered Vehicles</h2>
        <table>
            <tr><th>ID</th><th>User ID</th><th>Plate Number</th><th>Model</th></tr>
            <?php while ($v = $vehicles->fetch_assoc()): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= $v['user_id'] ?></td>
                    <td><?= $v['plate_number'] ?></td>
                    <td><?= $v['model'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
