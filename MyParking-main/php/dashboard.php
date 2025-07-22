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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Smart Parking</title>
  <link rel="stylesheet" href="styles.css" />
  <script>
    function setLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          position => {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
              .then(res => res.json())
              .then(data => document.getElementById("address-display").innerText = data.display_name)
              .catch(() => document.getElementById("address-display").innerText = "Unable to fetch address");
          },
          () => document.getElementById("address-display").innerText = "Location access denied"
        );
      }
    }

    function updateDefaultCard() {
      const card = localStorage.getItem("defaultCard") || "";
      document.getElementById("selected-card").innerText = `${card}`;
    }

    function updateDefaultVehicle() {
      const vehicle = localStorage.getItem("defaultVehicle") || "";
      document.getElementById("selected-vehicle").innerText = vehicle;
    }

    window.onload = function() {
      updateDefaultCard();
      updateDefaultVehicle();
      setLocation();
    };
  </script>
</head>
<body>
  <!-- Top Bar -->
  <div class="top-bar">
    <a class="top-button" href="payment_method.php">
      <span class="small-label">Payment</span><br />
      <span class="bold-label" id="selected-card"></span>
    </a>
    <a class="top-button" href="vehicle.php">
      <span class="small-label">Vehicle</span><br />
      <span class="bold-label" id="selected-vehicle"></span>
    </a>
  </div>

  <!-- Main Content -->
  <main class="main-box">
    <h2>Smart Parking Malaysia</h2>
    <p id="address-display" class="location-text">Detecting address...</p>
    <div class="btn-group">
      <button onclick="window.location.href='booking.php'">Pay Parking</button>
      <button onclick="window.location.href='history.php'">Parking History</button>
      <button onclick="window.location.href='logout.php'" style="background-color:#dc3545;">Logout</button>
    </div>
  </main>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
  header("Location: login.php");
  exit();
}
?>


