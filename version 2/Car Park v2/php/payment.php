<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Success - Smart Parking</title>
  <link rel="stylesheet" href="styles.css">
  <script>
    function redirectToHome() {
      alert("Booking Successful!");
      window.location.href = 'dashboard.php';
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Payment Successful</h2>
    <div class="confirmation-details">
      <p class="detail-item">Your parking has been booked successfully.</p>
    </div>
    <button onclick="redirectToHome()">Back to Home</button>
  </div>
</body>
</html>
