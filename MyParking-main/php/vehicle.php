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
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Vehicle Management</title>
  <link rel="stylesheet" href="styles.css"/>
</head>
<body>
  <div class="container">
    <a href="dashboard.php" class="back-btn">← Back</a>
    <h2>Vehicle Management</h2>

    <div id="vehicle-list"></div>

    <div class="add-vehicle">
      <h3>Add New Vehicle</h3>
      <input type="text" id="plateNumber" placeholder="Plate Number"/>
      <select id="colour">
        <option disabled selected>Select Colour</option>
        <option>Red</option>
        <option>Orange</option>
        <option>Green</option>
        <option>Blue</option>
        <option>White</option>
        <option>Black</option>
      </select>
      <select id="type">
        <option disabled selected>Select Type</option>
        <option>Car</option>
        <option>Motorcycle</option>
        <option>Truck</option>
      </select>
      <input type="text" id="brand" placeholder="Brand (Optional)"/>
      <button onclick="addVehicle()">Add Vehicle</button>
    </div>
  </div>

  <script>
    let vehicles = JSON.parse(localStorage.getItem("vehicles")) || [
      {plate: "MCN9144", colour: "White", type: "Car", brand: "Civic Type R"},
      {plate: "JRX4413", colour: "Red", type: "Car", brand: "Axia"},
      {plate: "JRV7711", colour: "Black", type: "Truck", brand: "D Max"}
    ];

    let defaultVehicle = localStorage.getItem("defaultVehicle") || "MCN9144";

    function renderVehicles() {
      const list = document.getElementById("vehicle-list");
      list.innerHTML = "";

      vehicles.forEach((vehicle, index) => {
        const item = document.createElement("div");
        item.className = "card";

        const label = document.createElement("span");
        label.textContent = `${vehicle.plate} - ${vehicle.brand || vehicle.type}`;

        const editBtn = document.createElement("button");
        editBtn.textContent = "Update";
        editBtn.onclick = () => updateVehicle(index);

        const radio = document.createElement("input");
        radio.type = "radio";
        radio.className = "radio";
        radio.name = "defaultVehicle";
        radio.checked = vehicle.plate === defaultVehicle;
        radio.onclick = () => {
          defaultVehicle = vehicle.plate;
          saveVehicles();
        };

        const actions = document.createElement("div");
        actions.className = "card-actions";
        actions.appendChild(editBtn);
        actions.appendChild(radio);

        item.appendChild(label);
        item.appendChild(actions);
        list.appendChild(item);
      });
    }

    function addVehicle() {
      const plate = document.getElementById("plateNumber").value.trim();
      const colour = document.getElementById("colour").value;
      const type = document.getElementById("type").value;
      const brand = document.getElementById("brand").value.trim();

      if (plate && colour && type) {
        vehicles.push({plate, colour, type, brand});
        saveVehicles();
      } else {
        alert("Please fill in plate number, colour, and type!");
      }
    }

    function updateVehicle(index) {
      const vehicle = vehicles[index];
      const newPlate = prompt("Plate Number:", vehicle.plate);
      const newColour = prompt("Colour:", vehicle.colour);
      const newType = prompt("Type (Car/Motorcycle/Truck):", vehicle.type);
      const newBrand = prompt("Brand (Optional):", vehicle.brand);

      if (newPlate && newColour && newType) {
        vehicles[index] = {
          plate: newPlate.trim(),
          colour: newColour.trim(),
          type: newType.trim(),
          brand: newBrand.trim()
        };
        saveVehicles();
      } else {
        alert("Please fill in plate number, colour, and type!");
      }
    }

    function saveVehicles() {
      localStorage.setItem("vehicles", JSON.stringify(vehicles));
      localStorage.setItem("defaultVehicle", defaultVehicle);
      renderVehicles();
    }

    renderVehicles();
  </script>
</body>
</html>
