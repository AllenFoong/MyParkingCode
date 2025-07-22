<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking - Smart Parking</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="container">
    <a href="dashboard.php" class="back-btn">← Back</a>
    <h2>Select Parking Duration</h2>

    <div id="initial-selection">
      <button onclick="showOptions('Hourly')">Hourly</button>
      <button onclick="selectDaily()">Daily</button>
    </div>

    <div id="hourly-options" style="display:none;">
      <h3>Select Duration</h3>
      <select id="duration" onchange="calculateHourlyFee()">
        <option disabled selected>Select duration</option>
      </select>
      <p>Parking Fee: <span id="hourly-fee">RM 0.00</span></p>
    </div>

    <div id="daily-option" style="display:none;">
      <p>Daily Parking selected: <strong>RM 6.00</strong></p>
    </div>

    <h3>Select Vehicle</h3>
    <select id="vehicle-selection">
      <option disabled selected>Choose your vehicle</option>
    </select>

    <button onclick="confirmBooking()">Confirm</button>
  </div>

  <script>
    let selectedFee = 0;
    let selectedDuration = '';

    function showOptions(type) {
      localStorage.setItem('bookingType', type);
      document.getElementById('initial-selection').style.display = 'none';
      if (type === 'Hourly') {
        document.getElementById('hourly-options').style.display = 'block';
        populateDurations();
      }
    }

    function populateDurations() {
      const durationSelect = document.getElementById('duration');
      durationSelect.innerHTML = '<option disabled selected>Select duration</option>';
      for (let i = 30; i <= 540; i += 30) {
        const hours = Math.floor(i / 60);
        const minutes = i % 60;
        const text = (hours ? hours + 'h ' : '') + (minutes ? minutes + 'm' : '');
        const option = document.createElement('option');
        option.value = i;
        option.textContent = text;
        durationSelect.appendChild(option);
      }
    }

    function calculateHourlyFee() {
      const minutes = parseInt(document.getElementById('duration').value);
      selectedFee = (minutes / 30) * 0.4;
      selectedDuration = document.getElementById('duration').options[document.getElementById('duration').selectedIndex].text;

      document.getElementById('hourly-fee').innerText = 'RM ' + selectedFee.toFixed(2);
    }

    function selectDaily() {
      selectedFee = 6;
      selectedDuration = 'Daily';
      localStorage.setItem('bookingType', 'Daily');

      document.getElementById('initial-selection').style.display = 'none';
      document.getElementById('daily-option').style.display = 'block';
    }

    function populateVehicles() {
      const vehicles = JSON.parse(localStorage.getItem("vehicles")) || [];
      const defaultVehicle = localStorage.getItem("defaultVehicle") || "";
      const select = document.getElementById("vehicle-selection");

      vehicles.forEach(vehicle => {
        const option = document.createElement('option');
        option.value = vehicle.plate;
        option.textContent = `${vehicle.plate} - ${vehicle.brand || vehicle.type}`;
        if (vehicle.plate === defaultVehicle) {
          option.selected = true;
        }
        select.appendChild(option);
      });
    }

    function confirmBooking() {
      const vehicleSelect = document.getElementById('vehicle-selection').value;
      if (!vehicleSelect || !selectedDuration || !selectedFee) {
        alert("Please select duration and vehicle!");
        return;
      }
      localStorage.setItem('bookingDuration', selectedDuration);
      localStorage.setItem('bookingFee', 'RM ' + selectedFee.toFixed(2));
      window.location.href = 'confirmation.php';
    }

    window.onload = populateVehicles;
  </script>
</body>

</html>

